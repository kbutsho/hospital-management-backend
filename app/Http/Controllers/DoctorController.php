<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use App\Validations\DoctorValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function getAllActiveDoctor(Request $request)
    {
        try {
            $departmentFilter = $request->query('department');
            $query = User::where('role', 'doctor')
                ->join('doctors', 'users.id', '=', 'doctors.user_id')
                ->join('departments', 'doctors.department_id', '=', 'departments.id')
                ->where('users.status', 'active')
                ->select(
                    'doctors.name as doctorName',
                    'departments.name',
                    'doctors.id',
                    'doctors.photo',
                    'users.email',
                    'users.phone'
                );
            if ($departmentFilter) {
                $query->where('departments.name', strtolower($departmentFilter));
            }
            $result = $query->get();
            return response()->json([
                'status' => true,
                'message' => 'Doctors retrieved successfully!',
                'data' => $result
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }


    // administrator: doctor list
    public function getAllDoctorForAdministrator(Request $request)
    {
        try {
            $perPage = $request->query('perPage') ?: 10;
            $searchTerm = $request->query('searchTerm');
            $statusFilter = $request->query('status');
            $departmentFilter = $request->query('department');
            $sortOrder = $request->query('sortOrder', 'desc');
            $sortBy = $request->query('sortBy', 'users.id');

            $query = User::where('role', 'doctor')
                ->join('doctors', 'users.id', '=', 'doctors.user_id')
                ->join('departments', 'doctors.department_id', '=', 'departments.id')
                ->select(
                    'users.id as userId',
                    'users.email as email',
                    'users.phone as phone',
                    'users.status as status',
                    'doctors.id as doctorId',
                    'doctors.name as name',
                    'doctors.bmdc_id as bmdc_id',
                    'doctors.address as address',
                    'doctors.designation as designation',
                    'departments.name as departmentName'
                )
                // ->with('chambers')
                ->orderBy($sortBy, $sortOrder);

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('users.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('users.email', 'like', '%' . $searchTerm . '%')
                        ->orWhere('users.phone', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors.designation', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors.address', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors.bmdc_id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('users.status', 'like', '%' . $searchTerm . '%')
                        ->orWhere('departments.name', 'like', '%' . $searchTerm . '%');
                });
            }
            if ($statusFilter) {
                $query->whereRaw('LOWER(users.status) = ?', strtolower($statusFilter));
            }
            if ($departmentFilter) {
                $query->whereRaw('LOWER(departments.name) = ?', strtolower($departmentFilter));
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
    // administrator: doctor status update
    public function updateDoctorStatus(Request $request)
    {
        try {
            $validation = new DoctorValidation();
            $rules = $validation->updateDoctorStatusRules;
            $messages = $validation->updateDoctorStatusMessages;
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
    // administrator: doctor delete
    public function deleteDoctor($id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            $user = User::where('id', '=', $doctor->user_id)->first();
            $doctor->delete();
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'doctor deleted successfully!'
            ], 204);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    // public function getDoctorListWithChambers()
    // {
    //     try {

    //         $activeDoctorsWithActiveUsers = Doctor::join('users', 'users.id', '=', 'doctors.user_id')
    //             ->where('users.status', 'active')
    //             ->with(['chambers' => function ($query) {
    //                 $query->select('id', 'address', 'doctor_id')
    //                     ->where('status', 'active');
    //             }])
    //             ->select('doctors.id', 'doctors.name')
    //             ->get();

    //         return $activeDoctorsWithActiveUsers;
    //     } catch (\Exception $e) {
    //         return ExceptionHandler::handleException($e);
    //     }
    // }
    public function getDoctorInfo($id)
    {
        try {
            $doctor = Doctor::where('id', '=', $id)->first();
            if ($doctor) {
                $user = User::where('id', '=', $doctor->user_id)->first();
                $department = Department::where('id', '=', $doctor->department_id)->first();
                $doctorInfo = [
                    'id' => $doctor->id,
                    'name' => $doctor->name,
                    'address' => $doctor->address,
                    'bio' => $doctor->bio,
                    'designation' => $doctor->designation,
                    'age' => $doctor->age,
                    'bmdc_id' => $doctor->bmdc_id,
                    'gender' => $doctor->gender,
                    'department_name' => $department->name,
                    'photo' => $doctor->photo,
                    'phone' => $user->phone,
                    'email' => $user->email
                ];
                return response()->json([
                    'status' => true,
                    'message' => 'doctor info get successfully!',
                    'data' => $doctorInfo
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'doctor not found!',
                    'error' => 'invalid doctor id!'
                ], 404);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
