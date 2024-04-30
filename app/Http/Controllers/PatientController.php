<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ExceptionHandler;
use App\Helpers\ROLE;
use App\Helpers\STATUS;
use App\Helpers\ValidationHandler;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\User;
use App\Validations\PatientValidation;
use Tymon\JWTAuth\Facades\JWTAuth;

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
    public function getAllPatient(Request $request)
    {
        try {
            $perPage = $request->query('perPage') ?: 10;
            $searchTerm = $request->query('searchTerm');
            $sortOrder = $request->query('sortOrder', 'desc');
            $sortBy = $request->query('sortBy', 'patients.id');
            $query = Patient::select(
                'id',
                'name',
                'age',
                'address',
                'gender',
                'phone',
                'email',
                'emergency_contact_number',
                'emergency_contact_name',
                'emergency_contact_relation',
                'blood_group'
            )->orderBy($sortBy, $sortOrder);

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('patients.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.age', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.address', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.phone', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.gender', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.email', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.emergency_contact_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.emergency_contact_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.emergency_contact_relation', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.blood_group', 'like', '%' . $searchTerm . '%');
                });
            }
            $paginationData = $query->paginate($perPage);
            $total = Patient::count();
            return response()->json([
                'status' => true,
                'message' => count($paginationData->items()) . " items fetched successfully!",
                'fetchedItems' => $paginationData->total(),
                'currentPage' => $paginationData->currentPage(),
                'totalItems' => $total,
                'data' => $paginationData->items()
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function getDoctorsAllPatient(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $doctorId = Doctor::where('user_id', $user->id)->value('id');
            $my_prescriptions = Prescription::where('doctor_id', $doctorId)->get();
            $uniquePatientIds = $my_prescriptions->unique('patient_id')->pluck('patient_id')->toArray();


            $perPage = $request->query('perPage') ?: 10;
            $searchTerm = $request->query('searchTerm');
            $sortOrder = $request->query('sortOrder', 'desc');
            $sortBy = $request->query('sortBy', 'patients.id');
            $query = Patient::whereIn('id', $uniquePatientIds)->select(
                'id',
                'name',
                'age',
                'address',
                'gender',
                'phone',
                'email',
                'emergency_contact_number',
                'emergency_contact_name',
                'emergency_contact_relation',
                'blood_group'
            )->orderBy($sortBy, $sortOrder);
            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('patients.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.age', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.address', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.phone', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.gender', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.email', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.emergency_contact_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.emergency_contact_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.emergency_contact_relation', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.blood_group', 'like', '%' . $searchTerm . '%');
                });
            }
            $paginationData = $query->paginate($perPage);
            $total = Patient::count();

            return response()->json([
                'status' => true,
                'message' => count($paginationData->items()) . " items fetched successfully!",
                'fetchedItems' => $paginationData->total(),
                'currentPage' => $paginationData->currentPage(),
                'totalItems' => $total,
                'data' => $paginationData->items()
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function deletePatient($id)
    {
        try {
            $data = Patient::findOrFail($id);
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'patient deleted successfully!'
            ], 204);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function getPatientDetails($id)
    {
        try {
            $patientData = Patient::where('id', $id)->first();
            $user = JWTAuth::parseToken()->authenticate();
            $doctorId = Doctor::where('user_id', $user->id)->value('id');
            $prescriptions = Prescription::where('patient_id', $id)->get();

            // Fetch doctor's name for each prescription
            if ($prescriptions) {
                foreach ($prescriptions as $prescription) {
                    $doctorName = Doctor::where('id', $prescription->doctor_id)->value('name');
                    $prescription->doctor_name = $doctorName ?? null;
                    $prescription->isEditable = ($prescription->doctor_id === $doctorId) ? 1 : 0;
                }
            }

            return response()->json([
                'status' => true,
                'message' => "Items fetched successfully!",
                'data' => ['patient' => $patientData, 'prescriptions' =>  $prescriptions]
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function getAdminPatientDetails($id)
    {
        try {
            $patientData = Patient::where('id', $id)->first();
            // $user = JWTAuth::parseToken()->authenticate();
            // $doctorId = Doctor::where('user_id', $user->id)->value('id');
            $prescriptions = Prescription::where('patient_id', $id)->get();

            // Fetch doctor's name for each prescription
            if ($prescriptions) {
                foreach ($prescriptions as $prescription) {
                    $doctorName = Doctor::where('id', $prescription->doctor_id)->value('name');
                    $prescription->doctor_name = $doctorName ?? null;
                }
            }

            return response()->json([
                'status' => true,
                'message' => "Items fetched successfully!",
                'data' => ['patient' => $patientData, 'prescriptions' =>  $prescriptions]
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function updatePatient(Request $request, $id)
    {
        try {
            $validation = new PatientValidation();
            $rules = $validation->updatePatientRules;
            $messages = $validation->updatePatientMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }

            $patient = Patient::where('id', '=', $id)->first();

            if ($patient) {
                $existingPhone = Patient::where('phone', '=', $request->phone)->where('id', '!=', $id)->first();
                if ($request->email) {
                    $existingEmail = Patient::where('email', '=', $request->email)->where('id', '!=', $id)->first();
                    if ($existingPhone && $existingEmail) {
                        return response()->json([
                            'status' => false,
                            'message' => 'phone and email already exist!',
                            'error' => [
                                'email' => 'email already used for another patient!',
                                'phone' => 'phone number already used for another patient!'
                            ]
                        ], 422);
                    }

                    if ($existingEmail) {
                        return response()->json([
                            'status' => false,
                            'message' => 'email already exist!',
                            'error' => ['email' => 'email already used for another patient!']
                        ], 422);
                    }
                }
                if ($existingPhone) {
                    return response()->json([
                        'status' => false,
                        'message' => 'phone number already exist!',
                        'error' => ['phone' => 'phone number already used for another patient!']
                    ], 422);
                }


                $patient->name = $request->name;
                $patient->age = $request->age;
                $patient->address = $request->address;
                $patient->phone = $request->phone;
                $patient->email = $request->email;
                $patient->gender = $request->gender;
                $patient->blood_group = $request->blood_group;
                $patient->emergency_contact_name = $request->emergency_contact_name;
                $patient->emergency_contact_number = $request->emergency_contact_number;
                $patient->emergency_contact_relation = $request->emergency_contact_relation;
                $patient->save();
                return response()->json([
                    'status' => true,
                    'message' => 'patient updated successfully!'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'patient not found!'
                ], 404);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
