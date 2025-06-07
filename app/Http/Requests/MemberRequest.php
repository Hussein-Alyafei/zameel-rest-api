<?php

namespace App\Http\Requests;

use Orion\Http\Requests\Request;

class MemberRequest extends Request
{
    public function attachRules(): array
    {
        return [
            'is_representer' => 'sometimes|boolean',
        ];
    }
}
