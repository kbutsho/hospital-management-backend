<?php

namespace App\Validations;

class AdministratorValidation
{
    public $updateAdministratorProfileRules;
    public $updateAdministratorProfileMessages;

    public $updateAdministratorProfilePhotoRules;
    public $updateAdministratorProfilePhotoMessages;

    public function __construct()
    {
        $this->updateAdministratorProfileRules = [
            'name' => 'required|min:3|max:120',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'address' => 'required',
            'email' => 'required|email',
            'age' => 'required',
            'gender' => 'required',
        ];
        $this->updateAdministratorProfileMessages = [
            'name.required' => 'name is required!',
            'name.min' => 'name must be more than 2 characters!',
            'name.max' => 'name must be less than 40 characters!',
            'phone.required' => 'phone is required!',
            'address.required' => 'address is required!',
            'email.required' => 'email is required!',
            'email.email' => 'invalid email format!',
            'age.required' => 'age is required!',
            'gender.required' => 'gender is required!',
        ];

        $this->updateAdministratorProfilePhotoRules = [
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
        $this->updateAdministratorProfilePhotoMessages = [
            'photo.required' => 'Photo is required!',
            'photo.image' => 'Photo must be an image file.',
            'photo.mimes' => 'Photo must be either a JPEG or PNG file.',
            'photo.max' => 'Photo size cannot exceed 2048 kilobytes.',
        ];
    }
}
