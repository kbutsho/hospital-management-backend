<?php

namespace App\Http\Controllers;

use App\Helpers\ExceptionHandler;
use App\Helpers\ValidationHandler;
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
            $serial->name = $request->name;
            $serial->age = $request->age;
            $serial->address = $request->address;
            $serial->doctor_id = $request->doctor_id;
            $serial->department_id = $request->department_id;

            $serial->schedule_id = intval($schedule[0]);
            $serial->day = $schedule[1];
            $serial->date = Carbon::parse($request->date)->format('Y-m-d');
            $openingTime = convertTo24Hour($schedule[2], $schedule[3]);
            $serial->opening_time = $openingTime;
            $closingTime = convertTo24Hour($schedule[4], $schedule[5]);
            $serial->closing_time = $closingTime;
            $serial->save();




            $serialNo = Serial::where('schedule_id', $serial->schedule_id)
                ->whereDate('date', $serial->date)
                ->count();

            $serialInfo = Serial::with('doctor', 'department', 'schedule.chamber')
                ->where('id', $serial->id)
                ->first();

            $doctorName =  $serialInfo->doctor->name;
            $departmentName =  $serialInfo->department->name;
            $roomNumber =  $serialInfo->schedule->chamber->room;

            return response()->json([
                'status' => 'success',
                'message' => 'serial created successfully!',
                'data' => array_merge($serial->toArray(), [
                    'serial_no' => $serialNo,
                    'doctor_name' => $doctorName,
                    'department_name' => $departmentName,
                    'room_number' => $roomNumber
                ])
            ], 201);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}


/*
serial: payment_status: paid, unpaid
appointment: serial_id, serial_no
patient: (phone, name, address) unique 





*/