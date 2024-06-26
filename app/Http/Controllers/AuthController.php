<?php

namespace App\Http\Controllers;

use App\Helpers\STATUS;
use App\Helpers\ROLE;
use App\Models\Administrator;
use App\Models\Assistant;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Models\Department;
use App\Models\Patient;
use App\Validations\AuthValidation;

class AuthController extends Controller
{
    // administrator signup
    public function administratorSignup(Request $request)
    {
        try {
            // start validation
            $validation = new AuthValidation();
            $rules = $validation->administratorSignupRules;
            $messages = $validation->administratorSignupMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $isEmailExist = User::where([['email', '=', $request->email]])->first();
            $isPhoneExist = User::where([['phone', '=', $request->phone]])->first();
            if ($isEmailExist && $isPhoneExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'registration failed!',
                    'error' => [
                        "email" => "email already used!",
                        "phone" => "phone already used!",
                    ]
                ], 409);
            } else if ($isEmailExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'registration failed!',
                    'error' => [
                        "email" => "email already used!"
                    ]
                ], 409);
            } else if ($isPhoneExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'registration failed!',
                    'error' => [
                        "phone" => "phone already used!"
                    ]
                ], 409);
            }
            // create new user
            $user = new User();
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->status = STATUS::PENDING;
            $user->password = Hash::make($request->password);
            $user->save();

            // create new administrator
            if ($request->role === ROLE::ADMINISTRATOR) {
                $admin = new Administrator();
                $admin->user_id = $user->id;
                $admin->name = strtoupper($request->name);
                $admin->address = strtoupper($request->address);
                $admin->age = intval($request->age);
                $admin->gender = $request->gender;
                $admin->save();
                $adminData = [
                    'user_id' => $user->id,
                    'administrator_id' => $admin->id,
                    'name' => $admin->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'address' => $admin->address,
                    'age' => $admin->age,
                    'gender' => $admin->gender,
                    'status' => $user->status
                ];
                return response()->json([
                    'status' => true,
                    'message' => 'signup done! wait for approval!',
                    'data' => $adminData
                ], 202);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'invalid role selected!',
                    'error' => 'registration failed!'
                ], 422);
            }
        }
        // handel exceptional error
        catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    // doctor signup
    public function doctorSignup(Request $request)
    {
        try {
            // start validation
            $validation = new AuthValidation();
            $rules = $validation->doctorSignupRules;
            $messages = $validation->doctorSignupMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            //end validation
            // check duplicate entry
            $isEmailExist = User::where([['email', '=', $request->email]])->first();
            $isPhoneExist = User::where([['phone', '=', $request->phone]])->first();
            $isBMDCExist = Doctor::where([['bmdc_id', '=', $request->bmdc_id]])->first();
            $isDepartmentExist = Department::where([['id', '=', $request->department_id]])->first();
            if ($isEmailExist && $isPhoneExist && $isBMDCExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'registration failed!',
                    'error' => [
                        "email" => "email already used!",
                        "phone" => "phone already used!",
                        "bmdc_id" => "bmdc id already used!",
                    ]
                ], 409);
            } else if ($isEmailExist && $isPhoneExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'registration failed!',
                    'error' => [
                        "email" => "email already used!",
                        "phone" => "phone already used!",
                    ]
                ], 409);
            } else if ($isEmailExist && $isBMDCExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'registration failed!',
                    'error' => [
                        "email" => "email already used!",
                        "bmdc_id" => "bmdc id already used!",
                    ]
                ], 409);
            } else if ($isPhoneExist && $isBMDCExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'registration failed!',
                    'error' => [
                        "bmdc_id" => "bmdc id already used!",
                        "phone" => "phone already used!",
                    ]
                ], 409);
            } else if ($isEmailExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'registration failed!',
                    'error' => [
                        "email" => "email already used!"
                    ]
                ], 409);
            } else if ($isPhoneExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'registration failed!',
                    'error' => [
                        "phone" => "phone already used!"
                    ]
                ], 409);
            } else if ($isBMDCExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'registration failed!',
                    'error' => [
                        "bmdc_id" => "bmdc id already used!"
                    ]
                ], 409);
            }
            if (!$isDepartmentExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'registration failed!',
                    'error' => [
                        "department_id" => "invalid department selected!"
                    ]
                ], 409);
            }
            // create new user
            $user = new User();
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->status = STATUS::PENDING;
            $user->password = Hash::make($request->password);
            $user->save();
            // create new doctor
            if ($request->role === ROLE::DOCTOR) {
                $doctor = new Doctor();
                $doctor->user_id = $user->id;
                $doctor->name = strtoupper($request->name);
                $doctor->bmdc_id = $request->bmdc_id;
                $doctor->designation = $request->designation;
                $doctor->department_id = intval($request->department_id);
                $doctor->save();
                $department = Department::where('id', '=', $doctor->department_id)->first();
                $doctorData = [
                    'user_id' => $user->id,
                    'doctor_id' => $doctor->id,
                    'name' => $doctor->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'bmdc_id' => $doctor->bmdc_id,
                    'status' => $user->status,
                    'designation' => $doctor->designation,
                    'department' => $department->name
                ];
                return response()->json([
                    'status' => true,
                    'message' => 'signup done! wait for approval!',
                    'data' => $doctorData
                ], 202);
            }
        }
        // handel exceptional error
        catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }


    // assistant signup
    public function assistantSignup(Request $request)
    {
        try {
            // start validation
            $validation = new AuthValidation();
            $rules = $validation->assistantSignupRules;
            $messages = $validation->assistantSignupMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            //end validation

            // check duplicate entry
            $isConflict = User::where([
                ['email', '=', $request->email],
                ['phone', '=', $request->phone]
            ])->first();
            $isEmailExist = User::where([['email', '=', $request->email]])->first();
            $isPhoneExist = User::where([['phone', '=', $request->phone]])->first();

            if ($isConflict) {
                return response()->json([
                    'status' => false,
                    'message' => 'registration failed!',
                    'error' => [
                        "email" => "email already used!",
                        "phone" => "phone already used!",
                    ]
                ], 409);
            } else if ($isEmailExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'registration failed!',
                    'error' => [
                        "email" => "email already used!"
                    ]
                ], 409);
            } else if ($isPhoneExist) {
                return response()->json([
                    'status' => false,
                    'message' => 'phone already used!',
                    'error' => [
                        "phone" => "phone already used!"
                    ]
                ], 409);
            }

            // create new user
            $user = new User();
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->status = STATUS::PENDING;
            $user->password = Hash::make($request->password);
            $user->save();
            // create new assistant
            if ($request->role === ROLE::ASSISTANT) {
                $assistant = new Assistant();
                $assistant->user_id = $user->id;
                $assistant->name = strtoupper($request->name);
                $assistant->address = strtoupper($request->address);
                $assistant->age = intval($request->age);
                $assistant->gender = $request->gender;
                $assistant->save();
                $assistantData = [
                    'user_id' => $user->id,
                    'assistant_id' => $assistant->id,
                    'name' => $assistant->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'address' => $assistant->address,
                    'age' => $assistant->age,
                    'gender' => $assistant->gender,
                    'status' => $user->status
                ];
                return response()->json([
                    'status' => true,
                    'message' => 'signup done! wait for approval!',
                    'data' => $assistantData
                ], 202);
            }
        }
        // handel exceptional error
        catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    // patient signup
    public function patientSignup(Request $request)
    {
        try {
            // start validation
            $validation = new AuthValidation();
            $rules = $validation->patientSignupRules;
            $messages = $validation->patientSignupMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            //end validation
            // check phone already exist or not
            $isExist = User::where('phone', $request->phone)->first();
            if ($isExist) {
                return response()->json([
                    'status' => 'failed!',
                    'message' => 'registration failed!',
                    'error' => [
                        "phone" => "phone already used!"
                    ]
                ], 409);
            }
            // create new user
            $user = new User();
            $user->phone = $request->phone;
            $user->status = STATUS::ACTIVE;
            $user->role = ROLE::PATIENT;
            $user->save();
            // create new patient
            $patient = new Patient();
            $patient->user_id = $user->id;
            $patient->name = strtoupper($request->name);
            $patient->address = strtoupper($request->address);
            $patient->age = intval($request->age);
            $patient->blood_group = intval($request->blood_group);
            $patient->emergency_contact_name = $request->emergency_contact_name;
            $patient->emergency_contact_number = $request->emergency_contact_number;
            $patient->emergency_contact_relation = $request->emergency_contact_relation;
            $patient->gender = $request->gender;
            $patient->save();
            $patientData = [
                'user_id' => $user->id,
                'patient_id' => $patient->id,
                'name' => $patient->name,
                'address' => $patient->address,
                'age' => $patient->age,
                'gender' => $patient->age,
                'phone' => $user->phone,
                'emergency_contact_name' => $patient->emergency_contact_name,
                'emergency_contact_number' => $patient->emergency_contact_number,
                'emergency_contact_relation' => $patient->emergency_contact_relation,
            ];
            return response()->json([
                'status' => true,
                'message' => 'patient signup done!',
                'data' =>   $patientData
            ], 200);
        }
        // handel exceptional error
        catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    public function login(Request $request)
    {
        try {
            // start validation
            $validation = new AuthValidation();
            $rules = $validation->loginRules;
            $messages = $validation->loginMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            //end validation
            // check credential and password
            if (
                Auth::attempt(['email' => $request->credential, 'password' => $request->password])
                || Auth::attempt(['phone' => $request->credential, 'password' => $request->password])
            ) {
                // check user active or not
                $user = Auth::user();
                if ($user->status === STATUS::ACTIVE) {
                    $name = '';
                    $photo = '';
                    $role = $user->role;
                    if ($role === ROLE::ADMINISTRATOR) {
                        $admin = Administrator::where('user_id', $user->id)->first();
                        if ($admin) {
                            $name = $admin->name;
                            $photo = $admin->photo;
                        }
                    } else if ($role === ROLE::DOCTOR) {
                        $doctor = Doctor::where('user_id', $user->id)->first();
                        if ($doctor) {
                            $name = $doctor->name;
                            $photo = $doctor->photo;
                        }
                    } else if ($role === ROLE::ASSISTANT) {
                        $assistant = Assistant::where('user_id', $user->id)->first();
                        if ($assistant) {
                            $name = $assistant->name;
                            $photo = $assistant->photo;
                        }
                    } else {
                        // Handle unknown role
                        return response()->json([
                            'status' => false,
                            'message' => 'invalid user role!',
                        ], 401);
                    }
                    $token = JWTAuth::fromUser($user);
                    return response()->json([
                        'status' => true,
                        'message' => 'login successful!',
                        'name' => $name,
                        'role' => $role,
                        'token' => $token,
                        'photo' => $photo
                    ], 200);
                }
                // user not active
                else {
                    return response()->json([
                        'status' => false,
                        'message' => 'your account is ' . $user->status . '! ',
                        'error' => 'login failed. try again later!',
                    ], 403);
                }
            }
            // password or email not matched!
            return response()->json([
                'status' => false,
                'message' => 'invalid credential!',
                'error' => 'login failed. try again later!',
            ], 401);
        }
        // handel exceptional error
        catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
