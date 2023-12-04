<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Models\Assistant;
use App\Models\User;
use App\Validations\AssistantValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssistantController extends Controller
{
    public function getAllAssistantWithDoctorAndChamber(Request $request)
    {
        try {
            $perPage = $request->query('perPage') ?: 10;
            $searchTerm = $request->query('searchTerm');
            $statusFilter = $request->query('status');
            $doctorFilter = $request->query('doctor');
            $sortOrder = $request->query('sortOrder', 'asc');
            $sortBy = $request->query('sortBy', 'users.id');

            $query = User::where('role', 'assistant')
                ->join('assistants', 'users.id', '=', 'assistants.user_id')
                ->join('doctors', 'doctors.id', '=', 'assistants.doctor_id')
                ->join('chambers', 'chambers.id', '=', 'assistants.chamber_id')
                ->select(
                    'users.id as userId',
                    'users.email',
                    'users.phone',
                    'users.status as status',
                    'assistants.id as assistantId',
                    'assistants.name',
                    'assistants.address',
                    'doctors.name as doctorName',
                    'chambers.address as chamberAddress',
                )
                ->orderBy($sortBy, $sortOrder);

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('users.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('users.email', 'like', '%' . $searchTerm . '%')
                        ->orWhere('users.phone', 'like', '%' . $searchTerm . '%')
                        ->orWhere('assistants.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('assistants.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('assistants.address', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('users.status', 'like', '%' . $searchTerm . '%')
                        ->orWhere('chambers.address', 'like', '%' . $searchTerm . '%');
                });
            }
            if ($statusFilter) {
                $query->whereRaw('LOWER(users.status) = ?', strtolower($statusFilter));
            }
            if ($doctorFilter) {
                $query->whereRaw('LOWER(doctors.name) = ?', strtolower($doctorFilter));
            }
            $paginationData = $query->paginate($perPage);
            $total = Assistant::count();
            return response()->json([
                'status' => true,
                'message' => count($paginationData->items()) . " items fetched successfully!",
                'fetchedItems' => $paginationData->total(),
                'currentPage' => $paginationData->currentPage(),
                'totalItems' => $total,
                'data' => $paginationData->items()
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function updateAssistantStatus(Request $request)
    {
        try {
            $validation = new AssistantValidation();
            $rules = $validation->updateAssistantStatusRules;
            $messages = $validation->updateAssistantStatusMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $isExist = User::where('id', '=', $request->userId)->first();
            if ($isExist) {
                $isExist->status = $request->status;
                $isExist->save();
                return response()->json([
                    'status' => true,
                    'message' => 'status updated successfully!',
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'user not found!',
            ], 404);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function deleteAssistant($id)
    {
        try {
            $assistant = Assistant::findOrFail($id);
            $user = User::where('id', '=', $assistant->user_id)->first();
            $assistant->delete();
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'assistant deleted successfully!'
            ], 204);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
