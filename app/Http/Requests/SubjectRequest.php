<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class SubjectRequest extends Request
{

    public function updateRules(): array
    {
        return [
            'name' => 'sometimes|string|max:45|regex:/^[\p{L}\p{M}\s0-9]+$/u|unique:subjects,name',
        ];
    }

    public function storeRules(): array
    {
        return [
            'name' => 'required|string|max:45|regex:/^[\p{L}\p{M}\s0-9]+$/u|unique:subjects,name',
        ];
    }
}
