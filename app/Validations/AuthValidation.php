<?php

namespace App\Validations;

use App\Helpers\ROLE;
use Illuminate\Validation\Rule;

class AuthValidation
{
    public $loginRules;
    public $loginMessages;
    public $administratorSignupRules;
    public $administratorSignupMessages;
    public $doctorSignupRules;
    public $doctorSignupMessages;
    public $assistantSignupRules;
    public $assistantSignupMessages;
    public $patientSignupRules;
    public $patientSignupMessages;

    public function __construct()
    {
        $this->administratorSignupRules = [
            'name' => 'required|min:3|max:40',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|email',
            'address' => 'required|string|max:200',
            'role' => ['required', Rule::in([ROLE::ADMINISTRATOR])],
            'organization' => 'required|string|max:200',
            'designation' => 'required|string|max:200',
            'password' => [
                'required',
                'string',
                'min:10',
                'max:24',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
            'confirmPassword' => [
                'required',
                'same:password',
            ]
        ];
        $this->administratorSignupMessages = [
            'name.required' => 'name is required!',
            'name.min' => 'name must be more than 2 characters!',
            'name.max' => 'name must be less than 40 characters!',
            'phone.required' => 'phone is required!',
            'phone.regex' => 'invalid phone number!',
            'phone.min' => 'invalid phone number!',
            'phone.max' => 'invalid phone number!',
            'email.required' => 'email is required!',
            'email.email' => 'invalid email address!',
            'address.required' => 'address is required',
            'address.max' => 'address is too large!',
            'role.required' => 'role is required!',
            'role.in' => 'invalid role selected!',
            'organization.required' => 'organization name is required!',
            'organization.string' => 'invalid organization information!',
            'organization.max' => 'organization name is too large!',
            'designation.required' => 'designation name is required!',
            'designation.string' => 'invalid designation information!',
            'designation.max' => 'designation name is too large!',
            'password.required' => 'password is required!',
            'password.regex' => 'invalid password format!',
            'password.min' => 'must contain 10 characters!',
            'password.max' => 'password is too large!',
            'confirmPassword.required' => 'confirm password is required!',
            'confirmPassword.same' => 'confirm password not match!'
        ];
        $this->doctorSignupRules = [
            'name' => 'required|min:3|max:40',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|email',
            'bmdc_id' => 'required|string|max:40',
            'role' => ['required', Rule::in([ROLE::DOCTOR])],
            'department_id' => 'required|integer',
            'designation' => 'required|string|max:200',
            'password' => [
                'required',
                'string',
                'min:10',
                'max:24',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
            'confirmPassword' => [
                'required',
                'same:password'
            ]
        ];
        $this->doctorSignupMessages = [
            'name.required' => 'name is required!',
            'name.min' => 'name must be more than 2 characters!',
            'name.max' => 'name must be less than 40 characters!',
            'phone.required' => 'phone is required!',
            'phone.regex' => 'invalid phone number!',
            'phone.min' => 'invalid phone number!',
            'phone.max' => 'invalid phone number!',
            'email.required' => 'email is required!',
            'email.email' => 'invalid email address!',
            'bmdc_id.required' => 'bmdc id is required!',
            'bmdc_id.max' => 'invalid bmdc id!',
            'role.required' => 'role is required!',
            'role.in' => 'invalid role selected!',
            'department_id.required' => 'department name is required!',
            'department_id.integer' => 'invalid department selected!',
            'designation.required' => 'designation name is required!',
            'designation.string' => 'invalid designation formate!',
            'designation.max' => 'designation is too large!',
            'password.required' => 'password is required!',
            'password.regex' => 'invalid password format!',
            'password.min' => 'must contain 10 characters!',
            'password.max' => 'password is too large!',
            'confirmPassword.required' => 'confirm password is required!',
            'confirmPassword.same' => 'confirm password not match!'
        ];
        $this->assistantSignupRules = [
            'name' => 'required|min:3|max:40',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|email',
            'address' => 'required|string|max:200',
            'role' => [
                'required',
                Rule::in([
                    role::ASSISTANT
                ]),
            ],
            'doctor_id' => 'required|integer',
            'chamber_id' => 'required|integer',
            'password' => [
                'required',
                'string',
                'min:10',
                'max:24',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
            'confirmPassword' => [
                'required',
                'same:password'
            ]
        ];
        $this->assistantSignupMessages = [
            'name.required' => 'name is required!',
            'name.min' => 'name must be more than 2 characters!',
            'name.max' => 'name must be less than 40 characters!',
            'phone.required' => 'phone is required!',
            'phone.regex' => 'invalid phone number!',
            'phone.min' => 'invalid phone number!',
            'phone.max' => 'invalid phone number!',
            'email.required' => 'email is required!',
            'email.email' => 'invalid email address!',
            'address.required' => 'address is required!',
            'address.max' => 'address is too large!',
            'role.required' => 'role is required!',
            'role.in' => 'invalid role selected!',
            'doctor_id.required' => 'doctor is required!',
            'doctor_id.integer' => 'invalid doctor information!',
            'chamber_id.required' => 'chamber is required!',
            'chamber_id.integer' => 'invalid chamber information!',
            'password.required' => 'password is required!',
            'password.regex' => 'invalid password formate!',
            'password.min' => 'must contain 10 characters!',
            'password.max' => 'password is too large!',
            'confirmPassword.required' => 'confirm password is required!',
            'confirmPassword.same' => 'confirm password not match!'
        ];
        $this->patientSignupRules = [
            'name' => 'required|min:3|max:40',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'age' => 'required|integer',
            'gender' => 'required',
            'blood_group_id' => 'required|integer',
            'address' => 'required|string|max:200',
            'emergency_contact_number' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'emergency_contact_name' => 'required|min:3|max:40',
        ];
        $this->patientSignupMessages = [
            'name.required' => 'name is required!',
            'name.min' => 'name must be more than 2 characters!',
            'name.max' => 'name must be less than 40 characters!',
            'emergency_contact_name.required' => 'emergency contact name is required!',
            'emergency_contact_name.min' => 'name must be more than 2 characters!',
            'emergency_contact_name.max' => 'name must be less than 40 characters!',
            'phone.required' => 'phone is required!',
            'phone.regex' => 'invalid phone number!',
            'phone.min' => 'invalid phone number!',
            'phone.max' => 'invalid phone number!',
            'emergency_contact_number.required' => 'emergency contact number is required!',
            'emergency_contact_number.regex' => 'invalid phone number!',
            'emergency_contact_number.min' => 'invalid phone number!',
            'emergency_contact_number.max' => 'invalid phone number!',
            'age.required' => 'age is required!',
            'age.integer' => 'invalid age formate!',
            'blood_group_id.required' => 'blood group is required!',
            'blood_group_id.integer' => 'invalid blood group!',
            'gender.required' => 'gender is required!',
            'address.required' => 'address is required!',
            'address.string' => 'invalid address formate!',
            'address.max' => 'address is too large!'
        ];
        $this->loginRules = [
            'credential' => 'required',
            'password' => 'required',
        ];
        $this->loginMessages = [
            'credential.required' => 'email or phone is required!',
            'password.required' => 'password is required!',
        ];
    }
}
