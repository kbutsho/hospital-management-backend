<?php

namespace App\Validations;

class ChamberValidation
{
    public $createChamberRules;
    public $createChamberMessages;

    public function __construct()
    {
        $this->createChamberRules = [
            'address' => 'required|max:200',
        ];
        $this->createChamberMessages = [
            'address.required' => 'address is required!',
            'address.max' => 'location is too large!',
        ];
    }
}
