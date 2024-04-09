<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Models\Administrator;
use App\Models\User;
use App\Validations\AdministratorValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
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
