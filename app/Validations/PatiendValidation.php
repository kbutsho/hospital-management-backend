<?php

namespace App\Validations;

class PatientValidation
{
    public $createPatientRules;
    public $createPatientMessages;

    public function __construct()
    {
        $this->createPatientRules = [
            'name' => 'required|min:3|max:40',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'age' => 'required|integer',
            'gender' => 'required|integer',
            'address' => 'required|string',
        ];
        $this->createPatientMessages = [
            'name.required' => 'name is required!',
            'name.min' => 'name must be more than 2 characters!',
            'name.max' => 'name must be less than 40 characters!',
            'phone.required' => 'phone is required!',
            'phone.regex' => 'invalid phone number!',
            'phone.min' => 'invalid phone number!',
            'phone.max' => 'invalid phone number!',
            'age.required' => 'age is required!',
            'age.integer' => 'invalid age formate!',
            'address.required' => 'address is required!',
            'address.string' => 'invalid address formate!'
        ];
    }
}
