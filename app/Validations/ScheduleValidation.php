<?php

namespace App\Validations;

class ScheduleValidation
{
    public $createScheduleRules;
    public $createScheduleMessages;

    public function __construct()
    {
        $this->createScheduleRules = [
            'doctor_id' => 'required|integer',
            'chamber_id' => 'required|integer',
            'date' => 'required|date|date_format:d-m-Y',
            'day' => 'required|string',
            'opening_time' => 'required|date_format:h:i A',
            'close_time' => 'required|date_format:h:i A',
        ];
        $this->createScheduleMessages = [
            'doctor_id.required' => 'doctor information is required!',
            'doctor_id.integer' => 'invalid doctor information!',
            'chamber_id.required' => 'chamber information is required!',
            'chamber_id.integer' => 'invalid chamber information!',
            'date.required' => 'date is required!',
            'date.date' => 'invalid date information!',
            'date.date_format' => 'invalid date formation!',
            'day.required' => 'day is required!',
            'day.string' => 'invalid day information!',
            'opening_time.required' => 'opening time is required!',
            'opening_time.date_format' => 'invalid opening time format!',
            'close_time.required' => 'close time is required!',
            'close_time.date_format' => 'invalid close time format!',
        ];
    }
}
