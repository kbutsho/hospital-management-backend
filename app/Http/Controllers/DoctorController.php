<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Models\User;
use App\Validations\DoctorValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function getAllDoctor()
    {
        try {
            $doctors = User::where('role', 'doctor')
                ->join('doctors', 'users.id', '=', 'doctors.user_id')
                ->select(
                    'users.id as userId',
                    'users.email',
                    'users.phone',
                    'users.status',
                    'doctors.id as doctorId',
                    'doctors.name',
                    'doctors.address',
                    'doctors.designation',
                    'doctors.specialization_id as specializationId'
                )
                ->get();
            return response()->json([
                'status' => true,
                'message' => 'doctors retrieved successfully!',
                'data' => $doctors,
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
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
}
