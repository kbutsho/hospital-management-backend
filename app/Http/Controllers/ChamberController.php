<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\STATUS;
use App\Helpers\ValidationHandler;
use App\Models\Chamber;
use App\Models\Doctor;
use App\Validations\ChamberValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ChamberController extends Controller
{
    public function createChamber(Request $request)
    {
        try {
            // start validation
            $validation = new ChamberValidation();
            $rules = $validation->createOrUpdateChamberRules;
            $messages = $validation->createOrUpdateChamberMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            //end validation
            // extract user, doctor and chamber information
            $user = JWTAuth::parseToken()->authenticate();
            $doctor = Doctor::where('user_id', $user->id)->first();
            $isExist = Chamber::where('address', $request->location)
                ->where('user_id', $user->id)
                ->where('doctor_id', $doctor->id)
                ->first();
            // restrict duplicate entry
            if ($isExist) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'failed to created chamber!',
                    'error' => [
                        'address' => 'chamber already created!'
                    ]
                ], 409);
            }
            //create new chamber
            $chamber = new Chamber();
            $chamber->address = $request->address;
            $chamber->status = STATUS::PENDING;
            $chamber->user_id = $user->id;
            $chamber->doctor_id = $doctor->id;
            $chamber->save();
            return response()->json([
                'status' => 'success',
                'message' => 'chamber created successfully!',
                'data' => $chamber
            ], 200);
        }
        //handel exceptional error
        catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function getDoctorsChamber()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $doctor = Doctor::where('user_id', '=', $user->id)->first();
            if ($doctor) {
                $chambers = $doctor->chambers()->with('assistants')->get();
                return response()->json([
                    'status' => true,
                    'message' => 'chambers retrieved successfully!',
                    'data' => $chambers
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'invalid user!',
                    'error' => 'unexpected error!'
                ], 404);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function deleteChamber($id)
    {
        try {
            $chamber = Chamber::findOrFail($id);
            $chamber->delete();
            return response()->json([
                'status' => true,
                'message' => 'chamber deleted successfully!'
            ], 204);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function updateChamberStatus(Request $request)
    {
        try {
            $validation = new ChamberValidation();
            $rules = $validation->updateChamberStatusRules;
            $messages = $validation->updateChamberStatusMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $isExist = Chamber::where('id', '=', $request->id)->first();
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
                'message' => 'chamber not found!',
            ], 404);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    public function updateChamber(Request $request, $id)
    {
        try {

            $validation = new ChamberValidation();
            $rules = $validation->createOrUpdateChamberRules;
            $messages = $validation->createOrUpdateChamberMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $user = JWTAuth::parseToken()->authenticate();
            $doctor = Doctor::where('user_id', '=', $user->id)->first();
            $isExist = Chamber::where('address', '=', $request->address)
                ->where('doctor_id', '=', $doctor->id)
                ->where('user_id', '=', $user->id)->first();
            if ($isExist) {
                return response()->json([
                    'status' => false,
                    'error' => [
                        "address" => "chamber already exist!"
                    ],
                    'message' => 'failed to update chamber!',
                ], 409);
            };
            $data = Chamber::findOrFail($id);
            $data->address = $request->address;
            $data->save();
            return response()->json([
                'status' => true,
                'message' => 'chamber updated successfully!'
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function getChamberWithDoctorAndAssistant(Request $request)
    {
        try {
            $perPage = $request->query('perPage') ?: 10;
            $searchTerm = $request->query('searchTerm');
            $statusFilter = $request->query('status');
            $doctorFilter = $request->query('doctor');
            $sortOrder = $request->query('sortOrder', 'asc');
            $sortBy = $request->query('sortBy', 'chambers.id');

            $query = Chamber::with([
                'doctor:id,name',
                'assistants:id,name,chamber_id'
            ])
                ->select(
                    'chambers.id',
                    'chambers.address',
                    'chambers.status',
                    'chambers.doctor_id'
                )->orderBy($sortBy, $sortOrder);

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('chambers.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('chambers.address', 'like', '%' . $searchTerm . '%')
                        ->orWhere('chambers.status', 'like', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('doctor', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('id', 'like', '%' . $searchTerm . '%');
                })->orWhereHas('assistants', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($statusFilter) {
                $query->whereRaw('LOWER(chambers.status) = ?', strtolower($statusFilter));
            }
            if ($doctorFilter) {
                $query->whereHas('doctor', function ($query) use ($doctorFilter) {
                    $query->whereRaw('LOWER(name) = ?', strtolower($doctorFilter));
                });
            }



            $paginationData = $query->paginate($perPage);

            $total = Doctor::count();
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
}
