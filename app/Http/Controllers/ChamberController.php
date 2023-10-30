<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\STATUS;
use App\Helpers\ValidationHandler;
use App\Models\Chamber;
use App\Models\Doctor;
use App\Validations\ChamberValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ChamberController extends Controller
{
    public function createChamber(Request $request)
    {
        try {
            // start validation
            $validation = new ChamberValidation();
            $rules = $validation->createChamberRules;
            $messages = $validation->createChamberMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            //end validation
            // extract user, doctor and chamber information
            $user = JWTAuth::parseToken()->authenticate();
            $doctor = Doctor::where('user_id', $user->id)->first();
            $isExist = Chamber::where('location', $request->location)
                ->where('user_id', $user->id)
                ->where('doctor_id', $doctor->id)
                ->first();
            // restrict duplicate entry
            if ($isExist) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'chamber already created!',
                    'error' => 'failed to created chamber!'
                ], 409);
            }
            //create new chamber
            $chamber = new Chamber();
            $chamber->location = $request->location;
            $chamber->status = STATUS::PENDING;
            $chamber->user_id = $user->id;
            $chamber->doctor_id = $doctor->id;
            $chamber->save();
            return response()->json([
                'status' => 'success',
                'message' => 'chamber created successfully!',
                'data' => $chamber
            ], 200);
        }
        //handel exceptional error
        catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
