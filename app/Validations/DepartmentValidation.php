<?php

namespace App\Validations;

class DepartmentValidation
{
    public $createDepartmentRules;
    public $createDepartmentMessages;
    public $updateDepartmentRules;
    public $updateDepartmentMessages;

    public $updateDepartmentStatusRules;
    public $updateDepartmentStatusMessages;

    public function __construct()
    {
        $this->createDepartmentRules = [
            'name' => 'required',
            'description' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ];
        $this->createDepartmentMessages = [
            'name.required' => 'department name is required!',
            'description.required' => 'description is required!',
            'photo.required' => 'Photo is required!',
            'photo.image' => 'Photo must be an image file.',
            'photo.mimes' => 'Photo must be either a JPEG or PNG file.',
            'photo.max' => 'Photo size cannot exceed 2048 kilobytes.',
        ];
        $this->updateDepartmentRules = [
            'name' => 'required',
            // photo, description
        ];
        $this->updateDepartmentMessages = [
            'name.required' => 'department name is required!'
        ];

        $this->updateDepartmentStatusRules = [
            'id' => 'required',
            'status' => 'required',
        ];
        $this->updateDepartmentStatusMessages = [
            'status.required' => 'status is required!',
            'id.required' => 'department id is required!',
        ];
    }
}