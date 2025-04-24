<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Policies\UserPolicy;
use Orion\Http\Controllers\Controller;

class UserController extends Controller
{
    public const EXCLUDE_METHODS = ['store', 'destroy', 'update', 'show', 'restore'];

    protected $model = User::class;

    protected $policy = UserPolicy::class;

    public function filterableBy(): array
    {
        return ['name', 'role_id', 'email_verified_at', 'email', 'created_at'];
    }
}
