<?php

namespace App\Validations;

class ChamberValidation
{
    public $createOrUpdateChamberRules;
    public $createOrUpdateChamberMessages;

    public function __construct()
    {
        $this->createOrUpdateChamberRules = [
            'address' => 'required|max:200',
        ];
        $this->createOrUpdateChamberMessages = [
            'address.required' => 'address is required!',
            'address.max' => 'location is too large!',
        ];
    }
}
