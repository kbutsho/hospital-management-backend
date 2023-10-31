<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ROLE;
use App\Helpers\STATUS;
use App\Helpers\ValidationHandler;
use App\Models\Appointment;
use App\Models\Chamber;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Validations\AppointmentValidation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function createAppointment(Request $request)
    {
        try {
            // start validation
            $validation = new AppointmentValidation();
            $rules = $validation->createAppointmentRules;
            $messages = $validation->createAppointmentMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            //end validation
            // check chamber and doctor are valid or not
            $existChamber = Chamber::where('id', $request->chamber_id)
                ->where('doctor_id', $request->doctor_id)->first();
            $existDoctor = Doctor::where('id', $request->doctor_id)->first();
            // valid chamber and doctor
            if ($existChamber && $existDoctor) {
                $existUser = User::where('phone', $request->phone)->first();
                // user exist
                if ($existUser) {
                    // user as patient
                    if ($existUser->role === ROLE::PATIENT) {
                        $existPatient = Patient::where('user_id', $existUser->id)->first();
                        // check appointment already taken or not
                        $isTakenAppointment = Appointment::where('patient_id', $existPatient->id)
                            ->where(
                                'datetime',
                                Carbon::createFromFormat(
                                    'd-m-Y h:i A',
                                    $request->datetime
                                )->format('Y-m-d H:i:s')
                            )->first();
                        if ($isTakenAppointment) {
                            return response()->json([
                                'status' => 'failed',
                                'message' => 'appoint already taken!',
                                'error' => 'appointment registration failed!'
                            ], 422);
                        }
                        // create appointment
                        $appointment = new Appointment();
                        $appointment->user_id = $existUser->id;
                        $appointment->patient_id = $existPatient->id;
                        $appointment->doctor_id = $request->doctor_id;
                        $appointment->chamber_id = $request->chamber_id;
                        $appointment->datetime = Carbon::createFromFormat('d-m-Y h:i A', $request->datetime);;
                        $appointment->save();
                        // create appointment data 
                        $appointmentData = [
                            'name' => $existPatient->name,
                            'phone' => $existUser->phone,
                            'age' => $existPatient->age,
                            'gender' => $existPatient->gender,
                            'address' => $existPatient->address,
                            'doctorName' => $existDoctor->name,
                            'doctorDesignation' => $existDoctor->designation,
                            'chamberLocation' => $existChamber->location,
                            'time' => $appointment->datetime
                        ];
                        return response()->json([
                            'status' => 'success',
                            'message' => 'appointment registration successfully!',
                            'data' => $appointmentData
                        ], 201);
                    }
                    // user exist but not patient
                    else {
                        return response()->json([
                            'status' => 'failed',
                            'message' => 'phone already used!',
                            'error' => 'appointment registration failed!'
                        ], 422);
                    }
                } else {
                    // create user
                    $user = new User();
                    $user->phone = $request->phone;
                    $user->status = STATUS::ACTIVE;
                    $user->role = ROLE::PATIENT;
                    $user->save();
                    // create patient
                    $patient = new Patient();
                    $patient->user_id = $user->id;
                    $patient->name = $request->name;
                    $patient->address = $request->address;
                    $patient->age = intval($request->age);
                    $patient->gender = $request->gender;
                    $patient->save();
                    // create appointment
                    $appointment = new Appointment();
                    $appointment->user_id = $user->id;
                    $appointment->patient_id = $patient->id;
                    $appointment->doctor_id = $request->doctor_id;
                    $appointment->chamber_id = $request->chamber_id;
                    $appointment->datetime = Carbon::createFromFormat('d-m-Y h:i A', $request->datetime);;
                    $appointment->save();
                    // create appointment data
                    $appointmentData = [
                        'name' => $patient->name,
                        'phone' => $user->phone,
                        'age' => $patient->age,
                        'gender' => $patient->gender,
                        'address' => $patient->address,
                        'doctorName' => $existDoctor->name,
                        'doctorDesignation' => $existDoctor->designation,
                        'chamberLocation' => $existChamber->location,
                        'time' => $appointment->datetime
                    ];
                    return response()->json([
                        'status' => 'success',
                        'message' => 'appointment registration successfully!',
                        'data' => $appointmentData
                    ], 201);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'invalid doctor or chamber information!',
                    'error' => 'appointment registration failed!'
                ], 422);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
