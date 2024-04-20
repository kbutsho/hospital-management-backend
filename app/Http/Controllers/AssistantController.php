<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Models\AssignedAssistant;
use App\Models\Assistant;
use App\Models\Chamber;
use App\Models\User;
use App\Validations\AdministratorValidation;
use App\Validations\AssistantValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AssistantController extends Controller
{
    public function getAllAssistantWithChamber(Request $request)
    {
        try {
            $perPage = $request->query('perPage') ?: 10;
            $searchTerm = $request->query('searchTerm');
            $statusFilter = $request->query('status');
            $roomFilter = $request->query('room');
            $sortOrder = $request->query('sortOrder', 'desc');
            $sortBy = $request->query('sortBy', 'users.id');

            $query = User::where('role', 'assistant')
                ->join('assistants', 'users.id', '=', 'assistants.user_id')
                ->leftJoin('assigned_assistants', 'assistants.id', '=', 'assigned_assistants.assistant_id')
                ->leftJoin('chambers', 'assigned_assistants.chamber_id', '=', 'chambers.id')
                ->select(
                    'users.id as userId',
                    'users.email',
                    'users.phone',
                    'users.status as status',
                    'assistants.id as assistantId',
                    'assistants.name',
                    'assistants.address',
                    DB::raw('COALESCE(chambers.room, "null") as room')
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
                        ->orWhere('users.status', 'like', '%' . $searchTerm . '%')
                        ->orWhere('chambers.room', 'like', '%' . $searchTerm . '%');
                });
            }
            if ($statusFilter) {
                $query->whereRaw('LOWER(users.status) = ?', strtolower($statusFilter));
            }
            if ($roomFilter) {
                $query->whereRaw('LOWER(chambers.room) = ?', strtolower($roomFilter));
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
    // administrator: delete assistant
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

    // public: assistant info
    public function getAssistantInfo($id)
    {
        try {
            $assistant = Assistant::where('id', '=', $id)->first();
            if ($assistant) {
                $user = User::where('id', '=', $assistant->user_id)->first();
                $assignedAssistant = AssignedAssistant::where('assistant_id', '=', $assistant->id)->first();
                $chamber =  Chamber::where('id', '=', $assignedAssistant->chamber_id)->first();

                $assistantInfo = [
                    'id' => $assistant->id,
                    'name' => $assistant->name,
                    'address' => $assistant->address,
                    'age' => $assistant->age,
                    'gender' => $assistant->gender,
                    'room' => $chamber->room,
                    'photo' => $assistant->photo,
                    'phone' => $user->phone,
                    'email' => $user->email
                ];
                return response()->json([
                    'status' => true,
                    'message' => 'assistant info get successfully!',
                    'data' => $assistantInfo
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'assistant not found!',
                    'error' => 'invalid assistant id!'
                ], 404);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    // administrator: assistant profile update
    public function updateAssistantProfile(Request $request, $id)
    {
        try {
            $validation = new AssistantValidation();
            $rules = $validation->updateAssistantProfileRules;
            $messages = $validation->updateAssistantProfileMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $assistant = Assistant::where('id', '=', $id)->first();
            if ($assistant) {
                $user = User::where('id', '=', $assistant->user_id)->first();
                if (
                    $request->email != $user->email && User::where('email', $request->email)->exists()
                    && $request->phone != $user->phone && User::where('phone', $request->phone)->exists()
                ) {
                    return response()->json([
                        'status' => false,
                        'message' => "email and phone already used!",
                        'error' => [
                            'email' => "$request->email already used!",
                            'phone' => "$request->phone already used!"
                        ]
                    ], 422);
                }
                if ($request->email != $user->email && User::where('email', $request->email)->exists()) {
                    return response()->json([
                        'status' => false,
                        'message' => "email already used!",
                        'error' => [
                            'email' => "$request->email already used!",
                        ]
                    ], 422);
                }
                if ($request->phone != $user->phone && User::where('phone', $request->phone)->exists()) {
                    return response()->json([
                        'status' => false,
                        'message' => "phone already used!",
                        'error' => [
                            'phone' => "$request->phone already used!"
                        ]
                    ], 422);
                }

                $user->email = $request->email;
                $user->phone = $request->phone;
                $assistant->name = $request->name;
                $assistant->age = $request->age;
                $assistant->gender = $request->gender;
                $assistant->address = $request->address;

                $user->save();
                $assistant->save();

                $userInfo = [
                    'name' => $assistant->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $assistant->address,
                    'age' => $assistant->age,
                    'gender' => $assistant->gender,
                    'photo' => $assistant->photo
                ];
                return response()->json([
                    'status' => true,
                    'message' => 'profile update successfully!',
                    'data' => $userInfo
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'doctor not found!'
                ], 404);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    // administrator: update assistant profile photo
    public function updateAssistantProfilePhoto(Request $request, $id)
    {
        try {
            $validation = new AssistantValidation();
            $rules = $validation->updateAssistantProfilePhotoRules;
            $messages = $validation->updateAssistantProfilePhotoMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $assistant = Assistant::where('id', '=', $id)->first();
            if ($assistant) {
                if ($request->hasFile('photo')) {
                    if ($assistant->photo) {
                        $previousPhotoPath = public_path('uploads/assistantProfile/' . $assistant->photo);
                        if (file_exists($previousPhotoPath)) {
                            unlink($previousPhotoPath);
                        }
                    }
                    $photo = $request->file('photo');
                    $photoName = time() . '.' . $photo->getClientOriginalExtension();
                    $photo->move('uploads/assistantProfile/', $photoName);
                    $assistant->photo = $photoName;
                }
                $assistant->save();
                return response()->json([
                    'status' => true,
                    'message' => 'photo update successfully!',
                    'data' => $assistant
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'doctor not found!'
                ], 404);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    // administrator: assistant profile photo delete
    public function deleteAssistantProfilePhoto($id)
    {
        try {
            $assistant = Assistant::where('id', '=', $id)->first();
            if ($assistant) {
                if ($assistant->photo) {
                    $previousPhotoPath = public_path('uploads/assistantProfile/' . $assistant->photo);
                    if (file_exists($previousPhotoPath)) {
                        unlink($previousPhotoPath);
                    }
                }
                $assistant->photo = null;
                $assistant->save();
                return response()->json([
                    'status' => true,
                    'message' => 'photo delete successfully!',
                    'data' => $assistant
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'assistant not found!'
                ], 404);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    // administrator assistant password change
    public function changeAssistantPassword(Request $request, $id)
    {
        try {
            $validation = new AdministratorValidation();
            $rules = $validation->updateDoctorPasswordRules;
            $messages = $validation->updateDoctorPasswordMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $assistant = Assistant::where('id', '=', $id)->first();
            if ($assistant) {
                $user = User::where('id', '=', $assistant->user_id)->first();
                $user->password = Hash::make($request->new_password);
                $user->save();
                return response()->json([
                    'status' => true,
                    'message' => 'password change successfully!',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'assistant not found!'
                ], 404);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
