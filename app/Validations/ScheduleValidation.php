<?php

namespace App\Validations;

use App\Helpers\STATUS;
use Illuminate\Validation\Rule;

class ScheduleValidation
{
    public $createScheduleRules;
    public $createScheduleMessages;

    public function __construct()
    {
        $this->createScheduleRules = [
            'data*.doctor_id' => 'required|integer',
            'data*.chamber_id' => 'required|integer',
            'data*.day' => 'required|string',
            'data*.status' => ['required', Rule::in([STATUS::ACTIVE, STATUS::PENDING])],
            'data*.opening_time' => 'required|date_format:H:i',
            'data*.closing_time' => 'required|date_format:H:i',
        ];
        $this->createScheduleMessages = [
            'data*.doctor_id.required' => 'doctor information is required!',
            'data*.doctor_id.integer' => 'invalid doctor information!',
            'data*.chamber_id.required' => 'chamber information is required!',
            'data*.chamber_id.integer' => 'invalid chamber information!',
            'data*.day.required' => 'day is required!',
            'data*.day.string' => 'invalid day information!',
            'data*.status.required' => 'status is required!',
            'data*.opening_time.required' => 'opening time is required!',
            'data*.opening_time.date_format' => 'invalid opening time format!',
            'data*.closing_time.required' => 'close time is required!',
            'data*.closing_time.date_format' => 'invalid close time format!',
        ];
    }
}
