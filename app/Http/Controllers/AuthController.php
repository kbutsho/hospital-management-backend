<?php

namespace App\Http\Controllers;

use App\Helpers\STATUS;
use App\Helpers\ROLE;
use App\Models\Administrator;
use App\Models\Assistant;
use App\Models\Chamber;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Validations\AuthValidation;

class AuthController extends Controller
{
    // administrator & doctor registration
    public function registration(Request $request)
    {
        try {
            // start validation
            $validation = new AuthValidation();
            $rules = $validation->registrationRules;
            $messages = $validation->registrationMessages;
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
            if ($isConflict) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'email and phone number already used!',
                    'error' => 'registration failed!'
                ], 409);
            }
            $isEmailExist = User::where([['email', '=', $request->email]])->first();
            $isPhoneExist = User::where([['phone', '=', $request->phone]])->first();
            if ($isEmailExist) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'email already used!',
                    'error' => 'registration failed!'
                ], 409);
            }
            if ($isPhoneExist) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'phone number already used!',
                    'error' => 'registration failed!'
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
                $admin->name = $request->name;
                $admin->address = $request->address ?? null;
                $admin->save();
                $adminData = [
                    'user_id' => $user->id,
                    'administrator_id' => $admin->id,
                    'name' => $admin->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'address' => $admin->address,
                    'status' => $user->status
                ];
                return response()->json([
                    'status' => 'success',
                    'message' => 'registration successful! wait for approval!',
                    'data' => $adminData
                ], 202);
            }
            // create new doctor
            if ($request->role === ROLE::DOCTOR) {
                $doctor = new Doctor();
                $doctor->user_id = $user->id;
                $doctor->name = $request->name;
                $doctor->address = $request->address ?? null;
                $doctor->designation = $request->designation ?? null;
                $doctor->save();
                $doctorData = [
                    'user_id' => $user->id,
                    'doctor_id' => $doctor->id,
                    'name' => $doctor->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'address' => $doctor->address,
                    'status' => $user->status
                ];
                return response()->json([
                    'status' => 'success',
                    'message' => 'registration successful! wait for approval!',
                    'data' => $doctorData
                ], 202);
            }
        }
        // handel exceptional error
        catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    public function assistantRegistration(Request $request)
    {
        try {
            // start validation
            $validation = new AuthValidation();
            $rules = $validation->assistantRegistrationRules;
            $messages = $validation->assistantRegistrationMessages;
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
            if ($isConflict) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'email and phone number already used!',
                    'error' => 'registration failed!'
                ], 409);
            }
            $isEmailExist = User::where([['email', '=', $request->email]])->first();
            $isPhoneExist = User::where([['phone', '=', $request->phone]])->first();
            if ($isEmailExist) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'email already used!',
                    'error' => 'registration failed!'
                ], 409);
            }
            if ($isPhoneExist) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'phone number already used!',
                    'error' => 'registration failed!'
                ], 409);
            }
            $isDoctorExist = Doctor::where([['id', '=', $request->doctor_id]])->first();
            $isChamberExist = Chamber::where([['id', '=', $request->chamber_id]])->first();
            if (!$isDoctorExist && !$isChamberExist) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'invalid doctor & chamber information!',
                    'error' => 'registration failed!'
                ], 422);
            }
            if (!$isDoctorExist) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'invalid doctor information!',
                    'error' => 'registration failed!'
                ], 422);
            }
            if (!$isChamberExist) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'invalid chamber information!',
                    'error' => 'registration failed!'
                ], 422);
            }
            if ($isChamberExist->status !== STATUS::ACTIVE) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'chamber is now' . $isChamberExist->status . '! try again later!',
                    'error' => 'registration failed!'
                ], 422);
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
                $assistant->name = $request->name;
                $assistant->address = $request->address ?? null;
                $assistant->doctor_id = $request->doctor_id;
                $assistant->chamber_id = $request->chamber_id;
                $assistant->save();
                $assistantData = [
                    'user_id' => $user->id,
                    'assistant_id' => $assistant->id,
                    'name' => $assistant->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'address' => $assistant->address,
                    'status' => $user->status
                ];
                return response()->json([
                    'status' => 'success',
                    'message' => 'registration successful! wait for approval!',
                    'data' => $assistantData
                ], 202);
            }
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
                    // create jwt token for login
                    $token = JWTAuth::fromUser($user);
                    return response()->json([
                        'status' => 'success',
                        'message' => 'login successful!',
                        'user_id' => $user->id,
                        'user_role' => $user->role,
                        'token' => $token
                    ], 200);
                }
                // user not active
                else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'your account is ' . $user->status . '! try again later!',
                        'error' => 'login failed!',
                    ], 403);
                }
            }
            // password or email not matched!
            return response()->json([
                'status' => 'failed',
                'message' => 'invalid credentials!',
                'error' => 'login failed!',
            ], 401);
        }
        // handel exceptional error
        catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
