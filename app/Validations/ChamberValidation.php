<?php

namespace App\Validations;

class ChamberValidation
{
    public $createOrUpdateChamberRules;
    public $createOrUpdateChamberMessages;

    public $updateChamberStatusRules;
    public $updateChamberStatusMessages;

    public function __construct()
    {
        $this->createOrUpdateChamberRules = [
            'address' => 'required|max:200',
        ];
        $this->createOrUpdateChamberMessages = [
            'address.required' => 'address is required!',
            'address.max' => 'location is too large!',
        ];

        $this->updateChamberStatusRules = [
            'id' => 'required',
            'status' => 'required',
        ];
        $this->updateChamberStatusMessages = [
            'status.required' => 'status is required!',
            'id.required' => 'chamber id is required!',
        ];
    }
}
