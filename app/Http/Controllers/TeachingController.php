<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeachingRequest;
use App\Models\Teaching;
use App\Policies\TeachingPolicy;
use Orion\Http\Controllers\Controller;

class TeachingController extends Controller
{
    protected $model = Teaching::class;

    protected $policy = TeachingPolicy::class;

    protected $request = TeachingRequest::class;

    public const EXCLUDE_METHODS = ['update', 'batchUpdate', 'restore', 'batchRestore'];

    public function filterableBy(): array
    {
        return [
            'user_id',
            'group_id',
            'subject_id',
            'created_at',
            'updated_at',
        ];
    }
}
