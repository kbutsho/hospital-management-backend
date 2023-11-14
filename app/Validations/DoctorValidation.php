<?php

namespace App\Validations;

class DoctorValidation
{
    public $updateDoctorStatusRules;
    public $updateDoctorStatusMessages;

    public function __construct()
    {
        $this->updateDoctorStatusRules = [
            'userId' => 'required',
            'status' => 'required',
        ];
        $this->updateDoctorStatusMessages = [
            'status.required' => 'status is required!',
            'userId.required' => 'user id is required!',
        ];
    }
}
