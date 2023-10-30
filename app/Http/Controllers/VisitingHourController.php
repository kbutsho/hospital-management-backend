<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ROLE;
use App\Helpers\STATUS;
use App\Helpers\ValidationHandler;
use App\Models\Assistant;
use App\Models\Chamber;
use App\Models\Doctor;
use App\Models\VisitingHour;
use App\Validations\VisitingHourValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class VisitingHourController extends Controller
{
    // visiting schedule details create
    public function createVisitingHour(Request $request)
    {
        try {
            // start validation
            $validation = new VisitingHourValidation();
            $rules = $validation->createVisitingHourRules;
            $messages = $validation->createVisitingHourMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            //end validation
            // extract user, doctor, assistant and chamber information
            $user = JWTAuth::parseToken()->authenticate();
            $doctor = Doctor::where('user_id', $user->id)->first();
            $assistant = Assistant::where('user_id', $user->id)
                ->where('chamber_id', $request->chamber_id)
                ->where('doctor_id', $doctor->id)
                ->first();
            $chamber = Chamber::where('id', $request->chamber_id)
                ->where('doctor_id', $request->doctor_id)->first();
            // check chamber is active or not
            if ($chamber->status !== STATUS::ACTIVE) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'chamber is now ' . $chamber->status . '! try again later!',
                    'error' => 'failed to created visiting schedule!'
                ], 422);
            }
            // visiting schedule create by doctor
            if ($user->role === ROLE::DOCTOR) {
                if ($doctor->id === $request->doctor_id && $chamber) {
                    return $this->handleSaveVisitingSchedule($request);
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'unauthorized doctor!',
                        'error' => 'failed to created visiting schedule!'
                    ], 422);
                }
            }
            // visiting schedule create by assistant
            if ($user->role === ROLE::ASSISTANT) {
                if ($assistant) {
                    return $this->handleSaveSchedule($request);
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'unauthorized assistant!',
                        'error' => 'failed to created visiting schedule!'
                    ], 422);
                }
            }
        }
        // handel exceptional error
        catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    private function handleSaveVisitingSchedule(Request $request)
    {
        $visitingSchedule = new VisitingHour();
        $visitingSchedule->doctor_id = $request->doctor_id;
        $visitingSchedule->chamber_id = $request->chamber_id;
        $visitingSchedule->details = $request->details;
        $visitingSchedule->save();
        return response()->json([
            'status' => 'success',
            'message' => 'visiting schedule created successfully!',
            'data' => $visitingSchedule
        ], 201);
    }
}
