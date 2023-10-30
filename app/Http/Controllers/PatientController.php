<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ExceptionHandler;
use App\Helpers\ROLE;
use App\Helpers\STATUS;
use App\Helpers\ValidationHandler;
use App\Models\Patient;
use App\Models\User;
use App\Validations\PatientValidation;

class PatientController extends Controller
{
    public function createPatient(Request $request)
    {
        try {
            // start validation
            $validation = new PatientValidation();
            $rules = $validation->createPatientRules;
            $messages = $validation->createPatientMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            //end validation
            // check phone already exist or not
            $isExist = User::where('phone', $request->phone)->first();
            if ($isExist) {
                return response()->json([
                    'status' => 'failed!',
                    'message' => 'phone already used!',
                    'error' => 'registration failed!',
                ], 409);
            }
            // create new user
            $user = new User();
            $user->phone = $request->phone;
            $user->status = STATUS::ACTIVE;
            $user->role = ROLE::PATIENT;
            $user->save();
            // create new patient
            $patient = new Patient();
            $patient->user_id = $user->id;
            $patient->name = $request->name;
            $patient->address = $request->address;
            $patient->age = intval($request->age);
            $patient->save();
            $patientData = [
                'user_id' => $user->id,
                'patient_id' => $patient->id,
                'name' => $patient->name,
                'address' => $patient->address,
                'age' => $patient->age,
                'phone' => $user->phone,
            ];
            return response()->json([
                'status' => 'success',
                'message' => 'patient registration successfully!',
                'data' =>   $patientData
            ], 200);
        }
        // handel exceptional error
        catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
