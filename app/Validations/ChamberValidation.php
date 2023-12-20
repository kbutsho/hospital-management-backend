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
            'room' => 'required|max:50',
        ];
        $this->createOrUpdateChamberMessages = [
            'room.required' => 'room is required!',
            'room.max' => 'location is too large!',
        ];

        $this->updateChamberStatusRules = [
            'id' => 'required',
            'status' => 'required',
        ];
        $this->updateChamberStatusMessages = [
            'status.required' => 'status is required!',
            'id.required' => 'room id is required!',
        ];
    }
}
