<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class AssignmentRequest extends Request
{
    public function storeRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'subject_id' => 'required|integer|numeric|exists:subjects,id',
            'group_id' => 'required|integer|numeric|exists:groups,id',
        ];
    }

    public function updateRules(): array
    {
        return [
            'due_date' => 'required|date',
        ];
    }
}
