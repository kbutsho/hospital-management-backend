<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ROLE;
use App\Helpers\STATUS;
use App\Helpers\ValidationHandler;
use App\Models\Assistant;
use App\Models\Chamber;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Validations\ScheduleValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ScheduleController extends Controller
{
    public function createSchedule(Request $request)
    {
        try {
            // start validation
            $validation = new ScheduleValidation();
            $rules = $validation->createScheduleRules;
            $messages = $validation->createScheduleMessages;
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
                    'error' => 'failed to created schedule!'
                ], 422);
            }
            // schedule create by doctor
            if ($user->role === ROLE::DOCTOR) {
                if ($doctor->id === $request->doctor_id && $chamber) {
                    return $this->handleSaveSchedule($request);
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'unauthorized doctor!',
                        'error' => 'failed to created schedule!'
                    ], 422);
                }
            }
            // schedule create by assistant
            if ($user->role === ROLE::ASSISTANT) {
                if ($assistant) {
                    return $this->handleSaveSchedule($request);
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'unauthorized assistant!',
                        'error' => 'failed to created schedule!'
                    ], 422);
                }
            }
        }
        // handel exceptional error
        catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    private function handleSaveSchedule(Request $request)
    {
        $schedule = new Schedule();
        $schedule->doctor_id = $request->doctor_id;
        $schedule->chamber_id = $request->chamber_id;
        $schedule->date = date("Y-m-d", strtotime($request->date));
        $schedule->day = $request->day;
        $schedule->opening_time = date("H:i:s", strtotime($request->opening_time));
        $schedule->close_time = date("H:i:s", strtotime($request->close_time));
        $schedule->save();
        return response()->json([
            'status' => 'success',
            'message' => 'schedule created successfully!',
            'data' => $schedule
        ], 201);
    }
}
