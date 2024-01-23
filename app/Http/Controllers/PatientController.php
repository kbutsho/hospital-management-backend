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
                'blood_group_id'
            )->orderBy($sortBy, $sortOrder);

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('patients.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.age', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.address', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.phone', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.email', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.emergency_contact_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.emergency_contact_number', 'like', '%' . $searchTerm . '%')
                        ->orWhere('blood_group_id', 'like', '%' . $searchTerm . '%');
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
}
