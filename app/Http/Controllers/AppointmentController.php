<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
use App\Models\Appointment;
use App\Models\Assistant;
use App\Models\AssistantUnderDoctor;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Serial;
use App\Validations\AppointmentValidation;;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AppointmentController extends Controller
{
    // for administrator
    public function getAppointments(Request $request)
    {
        try {

            $perPage = $request->query('perPage') ?: 10;
            $searchTerm = $request->query('searchTerm');
            $statusFilter = $request->query('status');
            $doctorFilter = $request->query('doctor');
            $departmentFilter = $request->query('department');
            $dateFilter = $request->query('date');
            $timeSlotFilter = $request->query('schedule');
            $sortOrder = $request->query('sortOrder', 'desc');
            $sortBy = $request->query('sortBy', 'appointments.id');


            $query = Appointment::join('serials', 'appointments.serial_id', '=', 'serials.id')
                ->join('schedules', 'appointments.schedule_id', 'schedules.id')
                ->join('departments', 'serials.department_id', 'departments.id')
                ->join('patients', 'appointments.patient_id', 'patients.id')
                ->join('doctors', 'serials.doctor_id', 'doctors.id')
                ->join('doctors_fees', 'doctors.id', 'doctors_fees.doctor_id')
                ->select(
                    'appointments.id',
                    'patients.name',
                    'patients.id as patientId',
                    'patients.phone',
                    'patients.age',
                    'appointments.date',
                    'appointments.status',
                    'serials.doctor_id',
                    'doctors.id as doctorId',
                    'doctors.name as doctorName',
                    'departments.id as departmentId',
                    'departments.name as departmentName',
                    'schedules.opening_time',
                    'schedules.day',
                    'doctors_fees.fees'
                )->orderBy($sortBy, $sortOrder);

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('appointments.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.phone', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.age', 'like', '%' . $searchTerm . '%')
                        ->orWhere('appointments.date', 'like', '%' . $searchTerm . '%')
                        ->orWhere('appointments.status', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('departments.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('schedules.day', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors_fees.fees', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($statusFilter) {
                $query->whereRaw('LOWER(appointments.status) = ?', strtolower($statusFilter));
            }
            if ($doctorFilter) {
                $query->whereRaw('LOWER(doctors.id) = ?', strtolower($doctorFilter));
            }
            if ($departmentFilter) {
                $query->whereRaw('LOWER(departments.id) = ?', strtolower($departmentFilter));
            }
            if ($dateFilter) {
                $formattedDate = date('Y-m-d', strtotime($dateFilter));
                $query->whereDate('appointments.date', '=', $formattedDate);
            }
            if ($timeSlotFilter) {
                if (preg_match('/(\d{2}:\d{2}:\d{2})\s*-\s*(\d{2}:\d{2}:\d{2})/', $timeSlotFilter, $matches)) {
                    $startTime = $matches[1];
                    $endTime = $matches[2];
                    $query->where(function ($q) use ($startTime, $endTime) {
                        $q->where('schedules.opening_time', '=', $startTime)
                            ->where('schedules.closing_time', '=', $endTime);
                    });
                }
            }

            $paginationData = $query->paginate($perPage);
            $total = Appointment::count();
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
    // for doctor
    public function getDoctorAppointments(Request $request)
    {
        try {
            $perPage = $request->query('perPage') ?: 10;
            $searchTerm = $request->query('searchTerm');
            $statusFilter = $request->query('status');
            $dateFilter = $request->query('date');
            $timeSlotFilter = $request->query('schedule');
            $sortOrder = $request->query('sortOrder', 'asc');
            $sortBy = $request->query('sortBy', 'appointments.serial_number');

            // $user = Auth::user();
            $user = JWTAuth::parseToken()->authenticate();
            $doctorId = Doctor::where('user_id', $user->id)->value('id');

            $query = Appointment::join('serials', 'appointments.serial_id', '=', 'serials.id')
                ->where('serials.doctor_id', $doctorId)
                ->join('schedules', 'appointments.schedule_id', 'schedules.id')
                ->join('patients', 'appointments.patient_id', 'patients.id')
                ->join('doctors', 'serials.doctor_id', 'doctors.id')
                ->join('doctors_fees', 'doctors.id', 'doctors_fees.doctor_id')
                ->select(
                    'appointments.id',
                    'patients.name',
                    'patients.phone',
                    'patients.age',
                    'patients.id as patientId',
                    'patients.gender',
                    'appointments.date',
                    'appointments.status',
                    'appointments.serial_number',
                    'serials.doctor_id',
                    'schedules.opening_time',
                    'schedules.closing_time',
                    'schedules.day',
                    'doctors_fees.fees'
                )->orderBy($sortBy, $sortOrder);

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('appointments.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.phone', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.age', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.gender', 'like', '%' . $searchTerm . '%')
                        ->orWhere('appointments.date', 'like', '%' . $searchTerm . '%')
                        ->orWhere('appointments.status', 'like', '%' . $searchTerm . '%')
                        ->orWhere('schedules.day', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors_fees.fees', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($statusFilter) {
                $query->whereRaw('LOWER(appointments.status) = ?', strtolower($statusFilter));
            }

            if ($dateFilter) {
                $formattedDate = date('Y-m-d', strtotime($dateFilter));
                $query->whereDate('appointments.date', '=', $formattedDate);
            }
            if ($timeSlotFilter) {
                if (preg_match('/(\d{2}:\d{2}:\d{2})\s*-\s*(\d{2}:\d{2}:\d{2})/', $timeSlotFilter, $matches)) {
                    $startTime = $matches[1];
                    $endTime = $matches[2];
                    $query->where(function ($q) use ($startTime, $endTime) {
                        $q->where('schedules.opening_time', '=', $startTime)
                            ->where('schedules.closing_time', '=', $endTime);
                    });
                }
            }

            $paginationData = $query->paginate($perPage);
            $total = Appointment::count();
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
    // for administrator
    public function updateAppointmentStatus(Request $request)
    {
        try {
            $validation = new AppointmentValidation();
            $rules = $validation->updateAppointmentStatusRules;
            $messages = $validation->updateAppointmentStatusMessages;
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $Apt = Appointment::find($request->id);
            if (!$Apt) {
                return response()->json([
                    'status' => false,
                    'message' => 'appointment not found!',
                ], 404);
            }
            $Apt->status = $request->status;
            $Apt->save();
            return response()->json([
                'status' => true,
                'message' => 'status updated successfully!'
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    // 
    public function getAppointmentInfo($id)
    {
        try {
            $aptInfo = Appointment::where('id', '=', $id)->first();
            if ($aptInfo) {
                $patient = Serial::where('id', '=', $aptInfo->serial_id)->first();

                return response()->json([
                    'status' => true,
                    'message' => 'appointment get successfully!',
                    'data' => $patient
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'appointment not found!',
                ], 404);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }


    // for assistant
    public function getAssistantAppointment(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $assistant_id = Assistant::where('user_id', $user->id)->value('id');
            $doctorId = AssistantUnderDoctor::where('assistant_id', $assistant_id)->value('doctor_id');

            $perPage = $request->query('perPage') ?: 10;
            $searchTerm = $request->query('searchTerm');
            $statusFilter = $request->query('status');
            $dateFilter = $request->query('date');
            $timeSlotFilter = $request->query('schedule');
            $sortOrder = $request->query('sortOrder', 'asc');
            $sortBy = $request->query('sortBy', 'appointments.serial_number');

            $query = Appointment::join('serials', 'appointments.serial_id', '=', 'serials.id')
                ->where('serials.doctor_id', $doctorId)
                ->join('schedules', 'appointments.schedule_id', 'schedules.id')
                ->join('patients', 'appointments.patient_id', 'patients.id')
                ->join('doctors', 'serials.doctor_id', 'doctors.id')
                ->join('doctors_fees', 'doctors.id', 'doctors_fees.doctor_id')
                ->select(
                    'appointments.id',
                    'patients.name',
                    'patients.phone',
                    'patients.age',
                    'patients.id as patientId',
                    'patients.gender',
                    'appointments.date',
                    'appointments.status',
                    'appointments.serial_number',
                    'serials.doctor_id',
                    'schedules.opening_time',
                    'schedules.closing_time',
                    'schedules.day',
                    'doctors_fees.fees'
                )->orderBy($sortBy, $sortOrder);

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('appointments.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.phone', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.age', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.gender', 'like', '%' . $searchTerm . '%')
                        ->orWhere('appointments.date', 'like', '%' . $searchTerm . '%')
                        ->orWhere('appointments.status', 'like', '%' . $searchTerm . '%')
                        ->orWhere('schedules.day', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors_fees.fees', 'like', '%' . $searchTerm . '%');
                });
            }
            if ($statusFilter) {
                $query->whereRaw('LOWER(appointments.status) = ?', strtolower($statusFilter));
            }
            if ($dateFilter) {
                $formattedDate = date('Y-m-d', strtotime($dateFilter));
                $query->whereDate('appointments.date', '=', $formattedDate);
            }
            if ($timeSlotFilter) {
                if (preg_match('/(\d{2}:\d{2}:\d{2})\s*-\s*(\d{2}:\d{2}:\d{2})/', $timeSlotFilter, $matches)) {
                    $startTime = $matches[1];
                    $endTime = $matches[2];
                    $query->where(function ($q) use ($startTime, $endTime) {
                        $q->where('schedules.opening_time', '=', $startTime)
                            ->where('schedules.closing_time', '=', $endTime);
                    });
                }
            }
            $paginationData = $query->paginate($perPage);
            $total = Appointment::count();
            return response()->json([
                'status' => true,
                'message' => count($paginationData->items()) . " items fetched successfully!",
                'fetchedItems' => $paginationData->total(),
                'currentPage' => $paginationData->currentPage(),
                'totalItems' => $total,
                'data' => $paginationData->items(),
                'doctorId' => $doctorId
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
