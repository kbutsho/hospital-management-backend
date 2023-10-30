<?php

namespace App\Validations;

use App\Helpers\ROLE;
use Illuminate\Validation\Rule;

class AuthValidation
{
    public $loginRules;
    public $loginMessages;
    public $registrationRules;
    public $registrationMessages;
    public $assistantRegistrationRules;
    public $assistantRegistrationMessages;

    public function __construct()
    {
        $this->registrationRules = [
            'name' => 'required|min:3|max:40',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|email',
            'role' => [
                'required',
                Rule::in([
                    ROLE::ADMINISTRATOR,
                    ROLE::DOCTOR,
                ]),
            ],
            'password' => [
                'required',
                'string',
                'min:10',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
            'confirm_password' => [
                'required',
                'same:password',
                'min:10',
            ]
        ];
        $this->registrationMessages = [
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
            'password.required' => 'password is required!',
            'password.regex' => 'invalid password format!',
            'password.min' => 'must contain 10 characters!',
            'confirm_password.required' => 'confirm password is required!',
            'confirm_password.same' => 'confirm password not match!'
        ];
        $this->assistantRegistrationRules = [
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
            'confirm_password' => [
                'required',
                'same:password',
                'min:10'
            ]
        ];
        $this->assistantRegistrationMessages = [
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
            'confirm_password.required' => 'confirm password is required!',
            'confirm_password.same' => 'confirm password not match!'
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
