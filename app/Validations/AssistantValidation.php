<?php

namespace App\Validations;

class AssistantValidation
{
    public $updateAssistantStatusRules;
    public $updateAssistantStatusMessages;

    public $updateAssistantProfileRules;
    public $updateAssistantProfileMessages;

    public $updateAssistantProfilePhotoRules;
    public $updateAssistantProfilePhotoMessages;

    public $updatePasswordRules;
    public $updatePasswordMessages;

    public function __construct()
    {
        $this->updateAssistantStatusRules = [
            'userId' => 'required',
            'status' => 'required',
        ];
        $this->updateAssistantStatusMessages = [
            'status.required' => 'status is required!',
            'userId.required' => 'user id is required!',
        ];

        $this->updateAssistantProfileRules = [
            'name' => 'required|min:3|max:120',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'address' => 'required',
            'email' => 'required|email',
            'age' => 'required',
            'gender' => 'required',
            // 'room' => 'required',
        ];
        $this->updateAssistantProfileMessages = [
            'name.required' => 'name is required!',
            'name.min' => 'name must be more than 2 characters!',
            'name.max' => 'name must be less than 40 characters!',
            'phone.required' => 'phone is required!',
            'address.required' => 'address is required!',
            'email.required' => 'email is required!',
            'email.email' => 'invalid email format!',
            'age.required' => 'age is required!',
            'gender.required' => 'gender is required!',
            // 'room.required' => 'room is required!',
        ];

        $this->updateAssistantProfilePhotoRules = [
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
        $this->updateAssistantProfilePhotoMessages = [
            'photo.required' => 'Photo is required!',
            'photo.image' => 'Photo must be an image file.',
            'photo.mimes' => 'Photo must be either a JPEG or PNG file.',
            'photo.max' => 'Photo size cannot exceed 2048 kilobytes.',
        ];

        $this->updatePasswordRules = [
            'old_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:10',
                'max:24',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
            'confirm_password' => [
                'required',
                'same:new_password',
            ]
        ];
        $this->updatePasswordMessages = [
            'old_password.required' => 'old password is required!',
            'new_password.required' => 'new password is required!',
            'new_password.regex' => 'invalid password format!',
            'new_password.min' => 'must contain 10 characters!',
            'new_password.max' => 'new password is too large!',
            'confirm_password.required' => 'confirm password is required!',
            'confirm_password.same' => 'confirm password not match!'
        ];
    }
}