<?php

namespace App\Validations;

class VisitingHourValidation
{
    public $createVisitingHourRules;
    public $createVisitingHourMessages;

    public function __construct()
    {
        $this->createVisitingHourRules = [
            'doctor_id' => 'required|integer',
            'chamber_id' => 'required|integer',
            'details' => 'required|string',
        ];
        $this->createVisitingHourMessages = [
            'doctor_id.required' => 'doctor information is required!',
            'doctor_id.integer' => 'invalid doctor information!',
            'chamber_id.required' => 'chamber information is required!',
            'chamber_id.integer' => 'invalid chamber information!',
            'details.required' => 'details is required!',
        ];
    }
}
