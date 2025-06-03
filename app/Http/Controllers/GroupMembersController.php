<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Group;
use App\Policies\MemberPolicy;
use Illuminate\Http\Request;
use Orion\Http\Controllers\RelationController;

class GroupMembersController extends RelationController
{
    protected $model = Group::class;

    protected $policy = MemberPolicy::class;

    protected $relation = 'members';

    public const EXCLUDE_METHODS = ['store', 'destroy', 'update', 'show', 'restore', 'attach', 'detach', 'sync', 'toggle', 'updatePivot'];
}
