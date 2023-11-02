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
            'address' => 'required',
            'role' => ['required', Rule::in([ROLE::ADMINISTRATOR])],
            'organization_id' => 'required|integer',
            'designation_id' => 'required|integer',
            'password' => [
                'required',
                'string',
                'min:10',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
            'confirmPassword' => [
                'required',
                'same:password',
                'min:10',
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
            'role.required' => 'role is required!',
            'role.in' => 'invalid role selected!',
            'organization_id.required' => 'organization name is required!',
            'organization_id.integer' => 'invalid organization selected!',
            'designation_id.required' => 'designation name is required!',
            'designation_id.integer' => 'invalid designation selected!',
            'password.required' => 'password is required!',
            'password.regex' => 'invalid password format!',
            'password.min' => 'must contain 10 characters!',
            'confirmPassword.required' => 'confirm password is required!',
            'confirmPassword.same' => 'confirm password not match!'
        ];
        $this->doctorSignupRules = [
            'name' => 'required|min:3|max:40',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|email',
            'address' => 'required',
            'role' => ['required', Rule::in([ROLE::DOCTOR])],
            'specialization_id' => 'required|integer',
            'designation' => 'required|string',
            'password' => [
                'required',
                'string',
                'min:10',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
            'confirmPassword' => [
                'required',
                'same:password',
                'min:10',
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
            'address.required' => 'address is required!',
            'role.required' => 'role is required!',
            'role.in' => 'invalid role selected!',
            'specialization_id.required' => 'specialization name is required!',
            'specialization_id.integer' => 'invalid specialization selected!',
            'designation.required' => 'designation name is required!',
            'designation.string' => 'invalid designation formate!',
            'password.required' => 'password is required!',
            'password.regex' => 'invalid password format!',
            'password.min' => 'must contain 10 characters!',
            'confirmPassword.required' => 'confirm password is required!',
            'confirmPassword.same' => 'confirm password not match!'
        ];
        $this->assistantSignupRules = [
            'name' => 'required|min:3|max:40',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|email',
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
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
            'confirmPassword' => [
                'required',
                'same:password',
                'min:10'
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
            'role.required' => 'role is required!',
            'role.in' => 'invalid role selected!',
            'doctor_id.required' => 'doctor is required!',
            'doctor_id.integer' => 'invalid doctor information!',
            'chamber_id.required' => 'chamber is required!',
            'chamber_id.integer' => 'invalid chamber information!',
            'password.required' => 'password is required!',
            'password.regex' => 'invalid password formate!',
            'password.min' => 'must contain 10 characters!',
            'confirmPassword.required' => 'confirm password is required!',
            'confirmPassword.same' => 'confirm password not match!'
        ];
        $this->patientSignupRules = [
            'name' => 'required|min:3|max:40',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'age' => 'required|integer',
            'gender' => 'required',
            'blood_group_id' => 'required|integer',
            'address' => 'required|string',
        ];
        $this->patientSignupMessages = [
            'name.required' => 'name is required!',
            'name.min' => 'name must be more than 2 characters!',
            'name.max' => 'name must be less than 40 characters!',
            'phone.required' => 'phone is required!',
            'phone.regex' => 'invalid phone number!',
            'phone.min' => 'invalid phone number!',
            'phone.max' => 'invalid phone number!',
            'age.required' => 'age is required!',
            'age.integer' => 'invalid age formate!',
            'blood_group_id.required' => 'blood group is required!',
            'blood_group_id.integer' => 'invalid blood group!',
            'gender.required' => 'gender is required!',
            'address.required' => 'address is required!',
            'address.string' => 'invalid address formate!'
        ];
        $this->loginRules = [
            'credential' => 'required',
            'password' => 'required',
        ];
        $this->loginMessages = [
            'credential.required' => 'email or phone is required!',
            'password.required' => 'password is required',
        ];
    }
}
