<?php

namespace App\Validations;

class SerialValidation
{
    public $createSerialRules;
    public $createSerialMessages;

    public function __construct()
    {
        $this->createSerialRules = [
            'name' => 'required|min:3|max:40',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'age' => 'required',
            'address' => 'required',
            'doctor_id' => 'required',
            'department_id' => 'required',
            'date' => 'required',
            'schedule_id' => 'required',
        ];
        $this->createSerialMessages = [
            'name.required' => 'name is required!',
            'name.min' => 'name must be more than 2 characters!',
            'name.max' => 'name must be less than 40 characters!',
            'age.required' => 'age is required!',
            'phone.required' => 'phone is required!',
            'address.required' => 'address is required!',
            'date.required' => 'date is required!',
            'schedule_id.required' => 'schedule is required!',
            'doctor_id.required' => 'doctor is required!',
            'department_id.required' => 'department is required!',
        ];
    }
}
