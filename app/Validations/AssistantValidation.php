<?php

namespace App\Validations;

class AssistantValidation
{
    public $updateAssistantStatusRules;
    public $updateAssistantStatusMessages;

    public function __construct()
    {
        $this->updateAssistantStatusRules = [
            'userId' => 'required',
            'status' => 'required',
        ];
        $this->updateAssistantStatusMessages = [
            'status.required' => 'status is required!',
            'userId.required' => 'user id is required!',
        ];
    }
}
