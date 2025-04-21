<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class ApplyRequest extends Request
{
    public function storeRules(): array
    {
        return [
            'group_id' => 'required|integer|numeric|exists:groups,id',
            'status_id' => 'required|integer|numeric|exists:statuses,id',
            'note' => 'sometimes|string|max:255',
        ];
    }
}
