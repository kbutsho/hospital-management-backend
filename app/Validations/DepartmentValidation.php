<?php

namespace App\Validations;

class DepartmentValidation
{
    public $createDepartmentRules;
    public $createDepartmentMessages;
    public $updateDepartmentRules;
    public $updateDepartmentMessages;

    public function __construct()
    {
        $this->createDepartmentRules = [
            'name' => 'required',
        ];
        $this->createDepartmentMessages = [
            'name.required' => 'department name is required!'
        ];
        $this->updateDepartmentRules = [
            'name' => 'required',
        ];
        $this->updateDepartmentMessages = [
            'name.required' => 'department name is required!'
        ];
    }
}