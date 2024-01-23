<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\STATUS;
use App\Helpers\ValidationHandler;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorsFee;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Serial;
use App\Validations\SerialValidation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SerialController extends Controller
{
    public function createSerial(Request $request)
    {
        try {
            $validation = new SerialValidation();
            $rules = $validation->createSerialRules;
            $messages = $validation->createSerialMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $schedule = explode(' ', $request->schedule);
            function convertTo24Hour($time, $meridian)
            {
                $hours = intval(substr($time, 0, 2));
                $minutes = intval(substr($time, 3, 2));
                if ($meridian === 'PM' && $hours < 12) {
                    $hours += 12;
                } elseif ($meridian === 'AM' && $hours === 12) {
                    $hours = 0;
                }
                return sprintf('%02d:%02d', $hours, $minutes);
            }

            $serial = new Serial();
            $serial->phone = $request->phone;
            $serial->name = strtoupper($request->name);
            $serial->age = $request->age;
            $serial->address = strtoupper($request->address);
            $serial->doctor_id = $request->doctor_id;
            $serial->department_id = $request->department_id;
            $serial->payment_status = 'unpaid';
            $serial->schedule_id = intval($request->schedule_id);
            $serial->date = Carbon::parse($request->date)->format('Y-m-d');

            $serial->save();

            $serialData = Serial::with('doctor', 'department', 'schedule')
                ->where('id', $serial->id)
                ->first();

            $doctorName =  $serialData->doctor->name;
            $departmentName =  $serialData->department->name;
            $roomNumber =  $serialData->schedule->chamber->room;
            $openingTime = $serialData->schedule->opening_time;
            $day = $serialData->schedule->day;
            $fees = DoctorsFee::where('doctor_id', $serial->doctor_id)->first();

            $serialInfo = [
                'id' => $serial->id,
                'name' => $serial->name,
                'age' => $serial->age,
                'phone' => $serial->phone,
                'address' => $serial->phone,
                'doctorName' => $doctorName,
                'roomNumber' => $roomNumber,
                'openingTime' => $openingTime,
                'day' => $day,
                'date' => $serial->date,
                'departmentName' => $departmentName,
                'paymentStatus' => $serial->payment_status,
                'fees' => $fees->fees
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'serial created successfully!',
                'data' => $serialInfo
            ], 201);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function getSerialById($id)
    {
        try {
            $serial = Serial::find($id);
            if ($serial) {
                $serialInfo = Serial::with('doctor', 'department', 'schedule')
                    ->where('id', $serial->id)
                    ->first();
                $doctorName =  $serialInfo->doctor->name;
                $departmentName =  $serialInfo->department->name;
                $roomNumber =  $serialInfo->schedule->chamber->room;
                $openingTime = $serialInfo->schedule->opening_time;
                $day = $serialInfo->schedule->day;

                $doctorFees = DoctorsFee::where('doctor_id', $serialInfo->doctor->id)->first();
                $doctorFeeAmount = $doctorFees ? $doctorFees->fee : 'not available';
                return response()->json([
                    'status' => 'success',
                    'message' => 'serial created successfully!',
                    'data' => array_merge($serial->toArray(), [
                        'serial_no' => 'pending',
                        'opening_time' => $openingTime,
                        'day' => $day,
                        'fees' => $doctorFeeAmount,
                        'doctor_name' => $doctorName,
                        'department_name' => $departmentName,
                        'room_number' => $roomNumber
                    ])
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'serial not found!',
                ], 400);
            }
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function getSerials(Request $request)
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
            $sortBy = $request->query('sortBy', 'serials.id');


            $query = Serial::join('doctors', 'serials.doctor_id', '=', 'doctors.id')
                ->join('departments', 'serials.department_id', 'departments.id')
                ->join('schedules', 'serials.schedule_id', 'schedules.id')
                ->join('doctors_fees', 'serials.doctor_id', 'doctors_fees.doctor_id')
                ->select(
                    'serials.id',
                    'serials.name',
                    'serials.phone',
                    'serials.age',
                    'serials.date',
                    'serials.payment_status',
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
                    $q->where('serials.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('serials.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('serials.phone', 'like', '%' . $searchTerm . '%')
                        ->orWhere('serials.age', 'like', '%' . $searchTerm . '%')
                        ->orWhere('serials.date', 'like', '%' . $searchTerm . '%')
                        ->orWhere('serials.payment_status', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('departments.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('schedules.day', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors_fees.fees', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($statusFilter) {
                $query->whereRaw('LOWER(serials.payment_status) = ?', strtolower($statusFilter));
            }
            if ($doctorFilter) {
                $query->whereRaw('LOWER(doctors.id) = ?', strtolower($doctorFilter));
            }
            if ($departmentFilter) {
                $query->whereRaw('LOWER(departments.id) = ?', strtolower($departmentFilter));
            }
            if ($dateFilter) {
                $formattedDate = date('Y-m-d', strtotime($dateFilter));
                $query->whereDate('serials.date', '=', $formattedDate);
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
            $total = Serial::count();
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
    public function updateSerialStatus(Request $request)
    {
        try {
            $validation = new SerialValidation();
            $rules = $validation->updateSerialStatusRules;
            $messages = $validation->updateSerialStatusMessages;
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $serial = Serial::find($request->id);
            if (!$serial) {
                return response()->json([
                    'status' => false,
                    'message' => 'Serial not found!',
                ], 404);
            }

            $serial->payment_status = $request->payment_status;
            $serial->save();



            $patient = Patient::firstOrCreate([
                'phone' => $serial->phone,
                'name' => $serial->name,
                'address' => $serial->address,
            ], [
                'name' => $serial->name,
                'age' => $serial->age,
                'phone' => $serial->phone,
                'address' => $serial->address,
            ]);

            if ($request->payment_status === 'unpaid') {
                Patient::where('name', $serial->name)
                    ->where('phone', $serial->phone)
                    ->delete();
            }

            $appointment = Appointment::where('serial_id', $serial->id)->first();
            if ($appointment) {
                $appointment->delete();
            } else {
                $newAppointment = new Appointment();
                $newAppointment->serial_id = $serial->id;
                $newAppointment->patient_id = $patient->id;
                $newAppointment->schedule_id = $serial->schedule_id;
                $newAppointment->date = $serial->date;
                $newAppointment->status = STATUS::CONFIRMED;

                $maxSerialNumber = Appointment::where('schedule_id', $serial->schedule_id)
                    ->where('date', $serial->date)->max('serial_number');
                $newAppointment->serial_number = $maxSerialNumber === null ? 1 : $maxSerialNumber + 1;
                $newAppointment->save();
            }
            return response()->json([
                'status' => true,
                'message' => 'status updated successfully!'
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    public function DoctorDepartmentAndScheduleList()
    {
        try {
            $doctors = Doctor::select('id', 'name')->get();
            $departments = Department::select('id', 'name')->get();

            $schedules = Schedule::all();
            $timeSlots = [];
            foreach ($schedules as $schedule) {
                $openingTime = $schedule->opening_time;
                $closingTime = $schedule->closing_time;
                $timeSlot = $openingTime . ' - ' . $closingTime;
                $timeSlots[] = $timeSlot;
            }
            sort($timeSlots);
            $uniqueTimeSlots = array_unique($timeSlots);
            $formattedTimeSlots = [];
            foreach ($uniqueTimeSlots as $slot) {
                $formattedTimeSlots[] = ['time' => $slot];
            }

            return response()->json([
                'status' => 'success',
                'message' => 'serial created successfully!',
                'data' => [
                    'doctors' => $doctors,
                    'departments' => $departments,
                    'schedule' => $formattedTimeSlots
                ]
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function deleteSerial($id)
    {
        try {
            $data = Serial::findOrFail($id);
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'serial deleted successfully!'
            ], 204);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
