<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Member;
use App\Policies\MemberPolicy;
use Orion\Http\Controllers\Controller;

class MemberController extends Controller
{
    protected $model = Member::class;

    protected $policy = MemberPolicy::class;

    protected $request = MemberRequest::class;

    public const EXCLUDE_METHODS = ['store', 'destroy', 'restore', 'show'];

    public function alwaysIncludes(): array
    {
        return ['user', 'group'];
    }

    public function filterableBy(): array
    {
        return ['created_at', 'is_representer', 'group_id', 'user_id'];
    }

    public function searchableBy(): array
    {
        return ['user.name'];
    }
}
