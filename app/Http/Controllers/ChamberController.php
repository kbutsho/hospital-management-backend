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
    // administrator: create chamber
    public function createAdministratorChamber(Request $request)
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

            // restrict duplicate entry
            $isExist = Chamber::where('room', $request->room)->first();
            if ($isExist) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'failed to created chamber!',
                    'error' => [
                        'room' => 'chamber already created!'
                    ]
                ], 409);
            }
            //create new chamber
            $chamber = new Chamber();
            $chamber->room = $request->room;
            $chamber->status = STATUS::ACTIVE;
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
    // administrator: get all chamber list
    public function getAdministratorChamber(Request $request)
    {
        try {
            $perPage = $request->query('perPage') ?: 10;
            $searchTerm = $request->query('searchTerm');
            $statusFilter = $request->query('status');
            $sortOrder = $request->query('sortOrder', 'desc');
            $sortBy = $request->query('sortBy', 'chambers.id');

            $query = Chamber::select('chambers.id', 'chambers.room', 'chambers.status')
                ->orderBy($sortBy, $sortOrder);

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('chambers.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('chambers.room', 'like', '%' . $searchTerm . '%')
                        ->orWhere('chambers.status', 'like', '%' . $searchTerm . '%');
                });
            }
            if ($statusFilter) {
                $query->whereRaw('LOWER(chambers.status) = ?', strtolower($statusFilter));
            }
            $paginationData = $query->paginate($perPage);
            $total = Chamber::count();
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
    // administrator: delete chamber
    public function deleteChamber($id)
    {
        try {
            $chamber = Chamber::findOrFail($id);
            $chamber->delete();
            return response()->json([
                'status' => true,
                'message' => 'room deleted successfully!'
            ], 204);
        } catch (\Exception $e) {
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

    public function getAllActiveRoom()
    {
        try {
            $rooms = Chamber::where('status', 'active')
                ->select('chambers.room as room')
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'rooms retrieved successfully!',
                'data' => $rooms,
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function getChamberDetails($id)
    {
        try {
            $chamber = Chamber::with(['schedules', 'schedules.doctor'])->find($id);


            if ($chamber) {
                return response()->json([
                    'status' => true,
                    'message' => 'chamber found successfully!',
                    'data' => $chamber
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'invalid chamber id!',
                ], 404);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    public function updateChamberRoom(Request $request, $id)
    {
        try {
            $validation = new ChamberValidation();
            $rules = $validation->createOrUpdateChamberRules;
            $messages = $validation->createOrUpdateChamberMessages;
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }

            $chamber = Chamber::where('id', '=', $id)->first();

            if ($chamber) {
                $existingChamber = Chamber::where('room', '=', $request->room)->where('id', '!=', $id)->first();
                if ($existingChamber) {
                    return response()->json([
                        'status' => false,
                        'message' => 'room already exists for another chamber!',
                        'error' => ['room' => 'room already exist']
                    ], 422);
                }

                $chamber->room = $request->room;
                $chamber->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Chamber updated successfully!'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Chamber not found!'
                ], 404);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
