<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class MemberRequest extends Request
{
    public function updateRules(): array
    {
        return [
            'is_representer' => 'boolean',
        ];
    }
}
