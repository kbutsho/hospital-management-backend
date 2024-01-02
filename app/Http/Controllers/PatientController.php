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
    public function getPatientByPhone($phone)
    {
        try {
            $patient = Patient::where('phone', $phone)->first();
            if ($patient) {
                return response()->json([
                    'status' => true,
                    'message' => 'patient found in this number!',
                    'data' => $patient
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'patient not found!'
                ], 201);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
