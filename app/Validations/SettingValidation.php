<?php

namespace App\Validations;

class SettingValidation
{
    public $updateSettingRules;
    public $updateSettingMessages;

    public function __construct()
    {
        $this->updateSettingRules = [
            'organization_name' => 'required|min:3|max:120',
            'phone' => 'required|min:11|max:14|regex:/^([0-9\s\-\+\(\)]*)$/',
            'address' => 'required',
            'about' => 'required',
            'email' => 'required',
            'facebook' => 'required',
            'youtube' => 'required',
        ];
        $this->updateSettingMessages = [
            'organization_name.required' => 'name is required!',
            'organization_name.min' => 'name must be more than 2 characters!',
            'organization_name.max' => 'name must be less than 40 characters!',
            'phone.required' => 'phone is required!',
            'address.required' => 'address is required!',
            'email.required' => 'email is required!',
            'facebook.required' => 'facebook is required!',
            'youtube.required' => 'youtube is required!',
            'about.required' => 'about is required!',
        ];
    }
}
