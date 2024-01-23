<?php

namespace App\Validations;

class AppointmentValidation
{

    public $updateAppointmentStatusRules;
    public $updateAppointmentStatusMessages;


    public function __construct()
    {

        $this->updateAppointmentStatusRules = [
            'id' => 'required',
            'status' => 'required',
        ];
        $this->updateAppointmentStatusMessages = [
            'status.required' => 'payment status is required!',
            'id.required' => 'department id is required!',
        ];
    }
}
