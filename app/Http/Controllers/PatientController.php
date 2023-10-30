<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ExceptionHandler;
use App\Helpers\role;
use App\Helpers\status;
use App\Models\Patient;
use App\Models\User;

class PatientController extends Controller
{
    public function createPatient(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|min:3|max:40',
                    'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
                    'age' => 'required',
                    'address' => 'required|string',
                ],
                [
                    'name.required' => 'name is required!',
                    'name.min' => 'name must be more than 2 characters!',
                    'name.max' => 'name must be less than 40 characters!',
                    'phone.required' => 'phone is required!',
                    'phone.regex' => 'invalid phone number!',
                    'phone.min' => 'invalid phone number!',
                    'phone.max' => 'invalid phone number!',
                    'age.required' => 'age is required!',
                    //'age.integer' => 'invalid age formate!',
                    'address.required' => 'address is required!',
                    'address.string' => 'invalid address formate!'
                ]
            );
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed!',
                    'message' => 'validation error!',
                    'error' => $validator->errors(),
                ], 422);
            }
            $isExist = User::where('phone', $request->phone)->first();
            if ($isExist) {
                return response()->json([
                    'status' => 'failed!',
                    'message' => 'phone already used!',
                    'error' => 'registration failed!',
                ], 409);
            }

            $user = new User();
            $user->phone = $request->phone;
            $user->status = status::ACTIVE;
            $user->role = role::PATIENT;
            $user->save();

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
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
