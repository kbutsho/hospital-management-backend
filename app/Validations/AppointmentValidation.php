<?php

namespace App\Validations;

class AppointmentValidation
{
    public $createAppointmentRules;
    public $createAppointmentMessages;

    public function __construct()
    {
        $this->createAppointmentRules = [
            'name' => 'required|min:3|max:40',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'age' => 'required|integer',
            'gender' => 'required',
            'address' => 'required',
            'datetime' => 'required|date_format:d-m-Y h:i A',
            'doctor_id' => 'required|integer',
            'chamber_id' => 'required|integer',
        ];
        $this->createAppointmentMessages = [
            'name.required' => 'name is required!',
            'name.min' => 'name must be more than 2 characters!',
            'name.max' => 'name must be less than 40 characters!',
            'age.required' => 'age is required!',
            'gender.required' => 'gender is required!',
            'address.required' => 'address is required!',
            'datetime.required' => 'datetime is required!',
            'datetime.date_format' => 'invalid time formate!',
            'doctor_id.required' => 'doctor information is required!',
            'chamber_id.required' => 'chamber information is required!',
        ];
    }
}
