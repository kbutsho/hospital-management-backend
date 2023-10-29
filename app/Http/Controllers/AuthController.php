<?php

namespace App\Http\Controllers;

use App\Helpers\status;
use App\Helpers\role;
use App\Models\Administrator;
use App\Models\Assistant;
use App\Models\Chamber;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // administrator & doctor registration
    public function Registration(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|min:3|max:40',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                    'email' => 'required|email',
                    'role' => [
                        'required',
                        Rule::in([
                            role::ADMINISTRATOR,
                            role::DOCTOR
                        ]),
                    ],
                    'password' => [
                        'required',
                        'string',
                        'min:10',
                        'regex:/[a-z]/',
                        'regex:/[A-Z]/',
                        'regex:/[0-9]/',
                        'regex:/[@$!%*#?&]/'
                    ],
                    'confirm_password' => [
                        'required',
                        'same:password',
                        'min:10'
                    ]
                ],
                [
                    'name.required' => 'name is required!',
                    'name.min' => 'name must be more than 2 characters!',
                    'name.max' => 'name must be less than 40 characters!',
                    'phone.required' => 'phone is required!',
                    'phone.regex' => 'invalid phone number!',
                    'email.required' => 'email is required!',
                    'email.email' => 'invalid email address!',
                    'role.required' => 'role is required!',
                    'role.in' => 'invalid role selected!',
                    'password.required' => 'password is required!',
                    'password.regex' => 'invalid password formate!',
                    'password.min' => 'must contain 10 characters!',
                    'confirm_password.required' => 'confirm password is required!',
                    'confirm_password.same' => 'confirm password not match!'
                ]
            );
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed!',
                    'message' => 'validation error!',
                    'error' => $validator->errors(),
                ], 422);
            }

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

            $user = new User();
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->status = status::PENDING;
            $user->password = Hash::make($request->password);
            $user->save();

            if ($request->role === role::ADMINISTRATOR) {
                $admin = new Administrator();
                $admin->user_id = $user->id;
                $admin->name = $request->name;
                $admin->address = $request->address ?? null;
                $admin->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'registration successful! wait for approval!',
                ], 202);
            }
            if ($request->role === role::DOCTOR) {
                $doctor = new Doctor();
                $doctor->user_id = $user->id;
                $doctor->name = $request->name;
                $doctor->address = $request->address ?? null;
                $doctor->designation = $request->designation ?? null;
                $doctor->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'registration successful! wait for approval!',
                ], 202);
            }
        } catch (\Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'internal server error',
                'error' => $error->getMessage(),
            ], 500);
        }
    }

    // assistant registration
    public function AssistantRegistration(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|min:3|max:40',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                    'email' => 'required|email',
                    'role' => [
                        'required',
                        Rule::in([
                            role::ASSISTANT
                        ]),
                    ],
                    'doctor_id' => 'required|integer',
                    'chamber_id' => 'required|integer',
                    'password' => [
                        'required',
                        'string',
                        'min:10',
                        'regex:/[a-z]/',
                        'regex:/[A-Z]/',
                        'regex:/[0-9]/',
                        'regex:/[@$!%*#?&]/'
                    ],
                    'confirm_password' => [
                        'required',
                        'same:password',
                        'min:10'
                    ]
                ],
                [
                    'name.required' => 'name is required!',
                    'name.min' => 'name must be more than 2 characters!',
                    'name.max' => 'name must be less than 40 characters!',
                    'phone.required' => 'phone is required!',
                    'phone.regex' => 'invalid phone number!',
                    'email.required' => 'email is required!',
                    'email.email' => 'invalid email address!',
                    'role.required' => 'role is required!',
                    'role.in' => 'invalid role selected!',
                    'doctor_id.required' => 'doctor is required!',
                    'chamber_id.required' => 'chamber is required!',
                    'password.required' => 'password is required!',
                    'password.regex' => 'invalid password formate!',
                    'password.min' => 'must contain 10 characters!',
                    'confirm_password.required' => 'confirm password is required!',
                    'confirm_password.same' => 'confirm password not match!'
                ]
            );
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'validation error!',
                    'error' => $validator->errors(),
                ], 422);
            } else {
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

                $isDoctorExist = Doctor::where([['user_id', '=', $request->doctor_id]])->first();
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

                $user = new User();
                $user->phone = $request->phone;
                $user->email = $request->email;
                $user->role = $request->role;
                $user->status = status::PENDING;
                $user->password = Hash::make($request->password);
                $user->save();

                if ($request->role === role::ASSISTANT) {
                    $assistant = new Assistant();
                    $assistant->user_id = $user->id;
                    $assistant->name = $request->name;
                    $assistant->address = $request->address ?? null;
                    $assistant->doctor_id = $request->doctor_id;
                    $assistant->chamber_id = $request->chamber_id;
                    $assistant->save();
                    return response()->json([
                        'status' => 'success',
                        'message' => 'registration successful! wait for approval!',
                    ], 202);
                }
            }
        } catch (\Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'internal server error!',
                'error' => $error->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'credential' => 'required',
                    'password' => 'required',
                ],
                [
                    'credential.required' => 'email or phone is required!',
                    'password.required' => 'password is required',
                ]
            );
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Validation error',
                    'error' => $validator->errors(),
                ], 422);
            }
            if (
                Auth::attempt(['email' => $request->credential, 'password' => $request->password]) ||
                Auth::attempt(['phone' => $request->credential, 'password' => $request->password])
            ) {
                $user = Auth::user();
                $token = JWTAuth::fromUser($user);
                return response()->json([
                    'status' => 'success',
                    'message' => 'login successful!',
                    'user_id' => $user->id,
                    'user_role' => $user->role,
                    'token' => $token
                ], 200);
            }
            return response()->json([
                'status' => 'failed',
                'message' => 'invalid credentials!',
                'error' => 'login failed!',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'internal server error!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
