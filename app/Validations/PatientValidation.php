<?php

namespace App\Validations;

use Illuminate\Validation\Rule;

class PatientValidation
{
    public $updatePatientRules;
    public $updatePatientMessages;

    public function __construct()
    {
        $this->updatePatientRules = [
            'name' => 'required|min:3|max:40',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'age' => 'required|integer',
            // 'email' => 'required|email',
            'gender' => [
                'required',
                Rule::in([
                    'male', 'female', 'other'
                ])
            ],
            // 'blood_group' => 'required',
            'address' => 'required|string|max:200',
            // 'emergency_contact_number' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            // 'emergency_contact_name' => 'required|min:3|max:40',
            // 'emergency_contact_relation' => 'required|min:3|max:40',
        ];
        $this->updatePatientMessages = [
            'name.required' => 'name is required!',
            'name.min' => 'name must be more than 2 characters!',
            'name.max' => 'name must be less than 40 characters!',
            // 'emergency_contact_name.required' => 'emergency contact name is required!',
            // 'emergency_contact_name.min' => 'name must be more than 2 characters!',
            // 'emergency_contact_name.max' => 'name must be less than 40 characters!',
            // 'emergency_contact_relation.required' => 'name must be less than 40 characters!',
            // 'emergency_contact_relation.max' => 'name must be less than 40 characters!',
            // 'emergency_contact_relation.min' => 'name must be less than 40 characters!',
            'phone.required' => 'phone is required!',
            'phone.regex' => 'invalid phone number!',
            'phone.min' => 'invalid phone number!',
            'phone.max' => 'invalid phone number!',
            // 'email.required' => 'email is required!',
            // 'email.email' => 'invalid email address!',
            // 'emergency_contact_number.required' => 'emergency contact number is required!',
            // 'emergency_contact_number.regex' => 'invalid phone number!',
            // 'emergency_contact_number.min' => 'invalid phone number!',
            // 'emergency_contact_number.max' => 'invalid phone number!',
            'age.required' => 'age is required!',
            'age.integer' => 'invalid age formate!',
            // 'blood_group.required' => 'blood group is required!',
            'gender.required' => 'gender is required!',
            'address.required' => 'address is required!',
            'address.string' => 'invalid address formate!',
            'address.max' => 'address is too large!'
        ];
    }
}