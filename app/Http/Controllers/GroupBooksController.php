<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Group;
use App\Policies\BookPolicy;
use App\Policies\MemberPolicy;
use Illuminate\Http\Request;
use Orion\Http\Controllers\RelationController;

class GroupBooksController extends RelationController
{
    protected $model = Group::class;

    protected $policy = BookPolicy::class;

    protected $relation = 'books';

    public const EXCLUDE_METHODS = ['store', 'destroy', 'update', 'show', 'restore', 'associate', 'dissociate'];
}
