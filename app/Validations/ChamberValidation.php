<?php

namespace App\Validations;

class ChamberValidation
{
    public $createChamberRules;
    public $createChamberMessages;

    public function __construct()
    {
        $this->createChamberRules = [
            'location' => 'required',
        ];
        $this->createChamberMessages = [
            'location.required' => 'location is required!',
        ];
    }
}
