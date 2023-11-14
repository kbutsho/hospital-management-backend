<?php

namespace App\Validations;

class SpecialistValidation
{
    public $createSpecialistRules;
    public $createSpecialistMessages;

    public function __construct()
    {
        $this->createSpecialistRules = [
            'name' => 'required',
        ];
        $this->createSpecialistMessages = [
            'name.required' => 'specialist name is required!'
        ];
    }
}
