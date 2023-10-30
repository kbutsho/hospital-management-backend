<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\status;
use App\Models\Chamber;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ChamberController extends Controller
{
    public function createChamber(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'location' => 'required',
                ],
                [
                    'location.required' => 'location is required!',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'validation error',
                    'error' => $validator->errors(),
                ], 422);
            }

            $user = JWTAuth::parseToken()->authenticate();
            $doctor = Doctor::where('user_id', $user->id)->first();
            $isExist = Chamber::where('location', $request->location)
                ->where('user_id', $user->id)
                ->where('doctor_id', $doctor->id)
                ->first();
            if ($isExist) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'chamber already created!',
                    'error' => 'failed to created chamber!'
                ], 409);
            }
            $chamber = new Chamber();
            $chamber->location = $request->location;
            $chamber->status = status::PENDING;
            $chamber->user_id = $user->id;
            $chamber->doctor_id = $doctor->id;
            $chamber->save();

            return response()->json([
                'status' => 'success',
                'message' => 'chamber created successfully!',
                'data' => $chamber
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
