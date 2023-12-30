<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\STATUS;
use App\Helpers\ValidationHandler;
use App\Models\Chamber;
use App\Models\Schedule;
use App\Models\User;
use App\Validations\ScheduleValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ScheduleController extends Controller
{
    // get doctor and chamber list for create schedule
    public function getDoctorAndChamberForCreateSchedule()
    {
        try {
            $doctors = User::where('role', 'doctor')
                ->join('doctors', 'users.id', '=', 'doctors.user_id')
                ->where('users.status', 'active')
                ->select('doctors.name', 'doctors.id')
                ->get();

            $chambers = Chamber::where('status', '=', 'active')
                ->select('chambers.room', 'chambers.id')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'data retrieved successfully!',
                'data' => [
                    'doctors' => $doctors,
                    'chambers' => $chambers
                ]
            ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    // administrator: create schedule
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

            $scheduleData = $request->input('data');
            foreach ($scheduleData as $data) {
                Schedule::create([
                    'doctor_id' => $data['doctor_id'],
                    'chamber_id' => $data['chamber_id'],
                    'day' => $data['day'],
                    'opening_time' => $data['opening_time'],
                    'closing_time' => $data['closing_time'],
                    'status' => STATUS::ACTIVE,
                    'details' => $data['day'] . ' ' . $data['opening_time'] . ' - ' . $data['closing_time']
                ]);
                // date("H:i:s", strtotime($data['opening_time']));

            }
            return response()->json([
                'status' => 'success',
                'message' => 'schedule created successfully!',
            ], 201);
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
        $schedule->day = $request->day;
        $schedule->status = $request->status;
        $schedule->details = $request->details;
        $schedule->opening_time = date("H:i:s", strtotime($request->opening_time));
        $schedule->closing_time = date("H:i:s", strtotime($request->closing_time));
        $schedule->save();
        return response()->json([
            'status' => 'success',
            'message' => 'schedule created successfully!',
            'data' => $schedule
        ], 201);
    }

    // administrator: get all schedule
    public function getAllScheduleWithDoctorAndChamber(Request $request)
    {
        try {
            $perPage = $request->query('perPage') ?: 10;
            $searchTerm = $request->query('searchTerm');
            $statusFilter = $request->query('status');
            $doctorFilter = $request->query('doctor');
            $roomFilter = $request->query('room');
            $dayFilter = $request->query('day');
            $timeSlotFilter = $request->query('timeSlot');
            $sortOrder = $request->query('sortOrder', 'asc');
            $sortBy = $request->query('sortBy', 'schedules.id');

            $query = Schedule::join('doctors', 'schedules.doctor_id', '=', 'doctors.id')
                ->join('chambers', 'schedules.chamber_id', '=', 'chambers.id')
                ->select(
                    'schedules.id as scheduleId',
                    'schedules.status as scheduleStatus',
                    'schedules.opening_time as openingTime',
                    'schedules.closing_time as closingTime',
                    'schedules.day as day',
                    'doctors.id as doctorId',
                    'doctors.name as doctorName',
                    'chambers.id as chamberId',
                    'chambers.room as room'
                )
                ->orderBy($sortBy, $sortOrder);

            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('schedules.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('schedules.status', 'like', '%' . $searchTerm . '%')
                        ->orWhere('schedules.day', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('doctors.name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('chambers.id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('chambers.room', 'like', '%' . $searchTerm . '%');
                });
            }

            if ($statusFilter) {
                $query->whereRaw('LOWER(schedules.status) = ?', strtolower($statusFilter));
            }
            if ($doctorFilter) {
                $query->whereRaw('LOWER(doctors.name) = ?', strtolower($doctorFilter));
            }
            if ($roomFilter) {
                $query->whereRaw('LOWER(chambers.room) = ?', strtolower($roomFilter));
            }
            if ($dayFilter) {
                $query->whereRaw('LOWER(schedules.day) = ?', strtolower($dayFilter));
            }
            if ($timeSlotFilter) {
                // (HH:MM:SS - HH:MM:SS)
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
            $total = Schedule::count();
            return response()->json([
                'status' => true,
                'message' => count($paginationData->items()) . " items fetched successfully!",
                'fetchedItems' => $paginationData->total(),
                'currentPage' => $paginationData->currentPage(),
                'totalItems' => $total,
                'data' => $paginationData->items()
            ], 200);

            // $data = Schedule::all();
            // return response()->json([
            //     'status' => true,
            //     'message' => 'schedule retrieved successfully!',
            //     'data' => $data,
            // ], 200);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function getAllTimeSlot()
    {
        try {
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
                'status' => true,
                'message' => "items fetched successfully!",
                'data' => $formattedTimeSlots
            ], 200);
        } catch (\Exception $e) {
            // Handle any exceptions
            return ExceptionHandler::handleException($e);
        }
    }
    public function deleteSchedule($id)
    {
        try {
            $data = Schedule::findOrFail($id);
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'deleted successfully!'
            ], 204);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
    public function updateScheduleStatus(Request $request)
    {
        try {
            $validation = new ScheduleValidation();
            $rules = $validation->updateScheduleStatusRules;
            $messages = $validation->updateScheduleStatusMessages;
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return ValidationHandler::handleValidation($validator);
            }
            $isExist = Schedule::where('id', '=', $request->id)->first();
            if ($isExist) {
                $isExist->status = $request->status;
                $isExist->save();
                return response()->json([
                    'status' => true,
                    'message' => 'status updated successfully!',
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'schedule not found!',
            ], 404);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
