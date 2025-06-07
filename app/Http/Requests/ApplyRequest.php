<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class ApplyRequest extends Request
{
    public function storeRules(): array
    {
        return [
            'note' => 'sometimes|string|max:255',
        ];
    }
}
