<?php

namespace App\Http\Controllers;

use App\Helpers\status;
use App\Helpers\userRole;
use App\Models\Chamber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
            $isExist = Chamber::where('location', $request->location)
                ->where('doctor_id', $user->id)->first();
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
            $chamber->doctor_id = $user->id;
            $chamber->save();

            return response()->json([
                'status' => 'success',
                'message' => 'chamber created successfully!',
                'data' => $chamber
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'internal server error!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
