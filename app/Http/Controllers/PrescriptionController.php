<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class PrescriptionController extends Controller
{
    public function patientWithPrescriptionData($id)
    {
        try {
            // $id = appointment_id
            $patientId = Appointment::where('id', $id)->value('patient_id');
            $patientData = Patient::where('id', $patientId)->first();
            $user = JWTAuth::parseToken()->authenticate();
            $doctorId = Doctor::where('user_id', $user->id)->value('id');
            $prescriptions = Prescription::where('patient_id', $patientId)->get();
            if ($prescriptions) {
                foreach ($prescriptions as $prescription) {
                    $prescription->isEditable = ($prescription->doctor_id === $doctorId) ? 1 : 0;
                }
            }
            return response()->json([
                'status' => true,
                'message' => "items fetched successfully!",
                'data' => ['patient' => $patientData, 'prescriptions' =>  $prescriptions]
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function savePrescription(Request $request)
    {
        try {
            $prescription = new Prescription();

            $user = JWTAuth::parseToken()->authenticate();
            $doctorId = Doctor::where('user_id', $user->id)->value('id');

            $prescription->patient_id = $request->patient_id;
            $prescription->appointment_id = $request->appointment_id;
            $prescription->medication = $request->medication;
            $prescription->history = $request->history;
            $prescription->doctor_id = $doctorId;
            $prescription->save();

            return response()->json([
                'status' => true,
                'message' => "prescribe successfully!",
                'data' => $prescription
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
