<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Models\Administrator;
use App\Models\Assistant;
use App\Models\Doctor;
use App\Models\User;
use App\Validations\AdministratorValidation;
use App\Validations\AssistantValidation;
use App\Validations\DoctorValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    // admin
    public function AdminProfile()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $admin = Administrator::where('user_id', '=', $user->id)->first();
            $userInfo = [
                'name' => $admin->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $admin->address,
                'age' => $admin->age,
                'gender' => $admin->gender,
                'photo' => $admin->photo,
            ];
            return response()->json([
                'status' => true,
                'message' => 'profile fetched successfully!',
                'data' => $userInfo
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function updateAdminProfile(Request $request)
    {
        try {
            $validation = new AdministratorValidation();
            $rules = $validation->updateAdministratorProfileRules;
            $messages = $validation->updateAdministratorProfileMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $auth_user = JWTAuth::parseToken()->authenticate();
            $user = User::where('id', '=', $auth_user->id)->first();
            $admin = Administrator::where('user_id', '=', $user->id)->first();

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
            // Check if email already exists for other users
            if ($request->email != $user->email && User::where('email', $request->email)->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => "email already used",
                    'error' => [
                        'email' => "$request->email already used!",
                    ]
                ], 422);
            }

            // Check if phone number already exists for other users
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
            $admin->name = $request->name;
            $admin->age = $request->age;
            $admin->gender = $request->gender;
            $admin->address = $request->address;

            $user->save();
            $admin->save();

            $userInfo = [
                'name' => $admin->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $admin->address,
                'age' => $admin->age,
                'gender' => $admin->gender,
                'photo' => $admin->photo,
            ];
            return response()->json([
                'status' => true,
                'message' => 'profile update successfully!',
                'data' => $userInfo
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function updateAdminProfilePhoto(Request $request)
    {
        try {
            $validation = new AdministratorValidation();
            $rules = $validation->updateAdministratorProfilePhotoRules;
            $messages = $validation->updateAdministratorProfilePhotoMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $auth_user = JWTAuth::parseToken()->authenticate();
            $admin = Administrator::where('user_id', '=', $auth_user->id)->first();

            if ($request->hasFile('photo')) {
                if ($admin->photo) {
                    $previousPhotoPath = public_path('uploads/adminProfile/' . $admin->photo);
                    if (file_exists($previousPhotoPath)) {
                        unlink($previousPhotoPath);
                    }
                }
                $photo = $request->file('photo');
                $photoName = time() . '.' . $photo->getClientOriginalExtension();
                $photo->move('uploads/adminProfile/', $photoName);
                $admin->photo = $photoName;
            }
            $admin->save();
            return response()->json([
                'status' => true,
                'message' => 'photo update successfully!',
                'data' => $admin
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function deleteAdminProfilePhoto()
    {
        try {
            $auth_user = JWTAuth::parseToken()->authenticate();
            $admin = Administrator::where('user_id', '=', $auth_user->id)->first();

            if ($admin->photo) {
                $previousPhotoPath = public_path('uploads/adminProfile/' . $admin->photo);
                if (file_exists($previousPhotoPath)) {
                    unlink($previousPhotoPath);
                }
            }
            $admin->photo = null;
            $admin->save();
            return response()->json([
                'status' => true,
                'message' => 'photo delete successfully!',
                'data' => $admin
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }


    // doctor
    public function DoctorProfile()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $doctor = Doctor::where('user_id', '=', $user->id)->first();

            $userInfo = [
                'name' => $doctor->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $doctor->address,
                'bio' => $doctor->bio,
                'designation' => $doctor->designation,
                'bmdc_id' => $doctor->bmdc_id,
                'age' => $doctor->age,
                'gender' => $doctor->gender,
                'photo' => $doctor->photo,
                'department_id' => $doctor->department_id,
            ];
            return response()->json([
                'status' => true,
                'message' => 'profile fetched successfully!',
                'data' => $userInfo
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function updateDoctorProfile(Request $request)
    {
        try {
            $validation = new DoctorValidation();
            $rules = $validation->updateDoctorProfileRules;
            $messages = $validation->updateDoctorProfileMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $auth_user = JWTAuth::parseToken()->authenticate();
            $user = User::where('id', '=', $auth_user->id)->first();
            $doctor = Doctor::where('user_id', '=', $user->id)->first();

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
            // Check if email already exists for other users
            if ($request->email != $user->email && User::where('email', $request->email)->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => "email already used",
                    'error' => [
                        'email' => "$request->email already used!",
                    ]
                ], 422);
            }

            // Check if phone number already exists for other users
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
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function updateDoctorProfilePhoto(Request $request)
    {
        try {
            $validation = new DoctorValidation();
            $rules = $validation->updateDoctorProfilePhotoRules;
            $messages = $validation->updateDoctorProfilePhotoMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $auth_user = JWTAuth::parseToken()->authenticate();
            $doctor = Doctor::where('user_id', '=', $auth_user->id)->first();

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
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function deleteDoctorProfilePhoto()
    {
        try {
            $auth_user = JWTAuth::parseToken()->authenticate();
            $doctor = Doctor::where('user_id', '=', $auth_user->id)->first();

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
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }


    // assistant
    public function AssistantProfile()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $assistant = Assistant::where('user_id', '=', $user->id)->first();
            $userInfo = [
                'name' => $assistant->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $assistant->address,
                'age' => $assistant->age,
                'gender' => $assistant->gender,
                'photo' => $assistant->photo,
            ];
            return response()->json([
                'status' => true,
                'message' => 'profile fetched successfully!',
                'data' => $userInfo
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function updateAssistantProfile(Request $request)
    {
        try {
            $validation = new AssistantValidation();
            $rules = $validation->updateAssistantProfileRules;
            $messages = $validation->updateAssistantProfileMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $auth_user = JWTAuth::parseToken()->authenticate();
            $user = User::where('id', '=', $auth_user->id)->first();
            $assistant = Assistant::where('user_id', '=', $user->id)->first();
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
            // Check if email already exists for other users
            if ($request->email != $user->email && User::where('email', $request->email)->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => "email already used",
                    'error' => [
                        'email' => "$request->email already used!",
                    ]
                ], 422);
            }
            // Check if phone number already exists for other users
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
                'photo' => $assistant->photo,
            ];
            return response()->json([
                'status' => true,
                'message' => 'profile update successfully!',
                'data' => $userInfo
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function updateAssistantProfilePhoto(Request $request)
    {
        try {
            $validation = new AssistantValidation();
            $rules = $validation->updateAssistantProfilePhotoRules;
            $messages = $validation->updateAssistantProfilePhotoMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $auth_user = JWTAuth::parseToken()->authenticate();
            $assistant = Assistant::where('user_id', '=', $auth_user->id)->first();
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
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function deleteAssistantProfilePhoto()
    {
        try {
            $auth_user = JWTAuth::parseToken()->authenticate();
            $assistant = Assistant::where('user_id', '=', $auth_user->id)->first();

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
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }


    // change password to all
    public function changePassword(Request $request)
    {
        try {
            $validation = new AdministratorValidation();
            $rules = $validation->updatePasswordRules;
            $messages = $validation->updatePasswordMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $user = JWTAuth::parseToken()->authenticate();
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return response()->json([
                    'status' => true,
                    'message' => 'password change successfully!',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'wrong old password!',
                    'error' => [
                        'old_password' => 'old password not matched!'
                    ]
                ], 422);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
