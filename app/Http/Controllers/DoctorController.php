<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use App\Validations\AdministratorValidation;
use App\Validations\DoctorValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    // public: doctor info
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
                    'department_id' => $department->id,
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
    // administrator: doctor profile update
    public function updateDoctorProfile(Request $request, $id)
    {
        try {
            $validation = new DoctorValidation();
            $rules = $validation->updateDoctorProfileRules;
            $messages = $validation->updateDoctorProfileMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $doctor = Doctor::where('id', '=', $id)->first();

            if ($doctor) {
                $user = User::where('id', '=', $doctor->user_id)->first();
                if (
                    $request->email != $user->email && User::where('email', $request->email)->exists()
                    && $request->phone != $user->phone && User::where('phone', $request->phone)->exists()
                ) {
                    return response()->json([
                        'status' => false,
                        'message' => "email and phone already used",
                        'error' => [
                            'email' => "$request->email already used!",
                            'phone' => "$request->phone already used!"
                        ]
                    ], 422);
                }
                if ($request->email != $user->email && User::where('email', $request->email)->exists()) {
                    return response()->json([
                        'status' => false,
                        'message' => "email already used",
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
                $doctor->name = $request->name;
                $doctor->age = $request->age;
                $doctor->gender = $request->gender;
                $doctor->address = $request->address;
                $doctor->bio = $request->bio;
                $doctor->designation = $request->designation;
                $doctor->bmdc_id = $request->bmdc_id;
                $doctor->department_id = $request->department_id;
                $user->save();
                $doctor->save();

                $userInfo = [
                    'name' => $doctor->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $doctor->address,
                    'age' => $doctor->age,
                    'gender' => $doctor->gender,
                    'photo' => $doctor->photo,
                    'designation' => $doctor->designation,
                    'bio' => $doctor->bio,
                    'department_id' => $doctor->department_id,
                    'bmdc_id' => $doctor->bmdc_id,
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
    // administrator: update doctor profile photo
    public function updateDoctorProfilePhoto(Request $request, $id)
    {
        try {
            $validation = new DoctorValidation();
            $rules = $validation->updateDoctorProfilePhotoRules;
            $messages = $validation->updateDoctorProfilePhotoMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $doctor = Doctor::where('id', '=', $id)->first();
            if ($doctor) {
                if ($request->hasFile('photo')) {
                    if ($doctor->photo) {
                        $previousPhotoPath = public_path('uploads/doctorProfile/' . $doctor->photo);
                        if (file_exists($previousPhotoPath)) {
                            unlink($previousPhotoPath);
                        }
                    }
                    $photo = $request->file('photo');
                    $photoName = time() . '.' . $photo->getClientOriginalExtension();
                    $photo->move('uploads/doctorProfile/', $photoName);
                    $doctor->photo = $photoName;
                }
                $doctor->save();
                return response()->json([
                    'status' => true,
                    'message' => 'photo update successfully!',
                    'data' => $doctor
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
    // administrator: doctor profile photo delete
    public function deleteDoctorProfilePhoto($id)
    {
        try {
            $doctor = Doctor::where('id', '=', $id)->first();
            if ($doctor) {
                if ($doctor->photo) {
                    $previousPhotoPath = public_path('uploads/doctorProfile/' . $doctor->photo);
                    if (file_exists($previousPhotoPath)) {
                        unlink($previousPhotoPath);
                    }
                }
                $doctor->photo = null;
                $doctor->save();
                return response()->json([
                    'status' => true,
                    'message' => 'photo delete successfully!',
                    'data' => $doctor
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
    // administrator doctor password change
    public function changeDoctorPassword(Request $request, $id)
    {
        try {
            $validation = new AdministratorValidation();
            $rules = $validation->updateDoctorPasswordRules;
            $messages = $validation->updateDoctorPasswordMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $doctor = Doctor::where('id', '=', $id)->first();
            if ($doctor) {
                $user = User::where('id', '=', $doctor->user_id)->first();
                $user->password = Hash::make($request->new_password);
                $user->save();
                return response()->json([
                    'status' => true,
                    'message' => 'password change successfully!',
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
}
