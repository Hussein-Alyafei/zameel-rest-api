<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Policies\TeachingPolicy;
use Orion\Http\Controllers\RelationController;

class GroupTeachersController extends RelationController
{
    protected $model = Group::class;

    protected $policy = TeachingPolicy::class;

    protected $relation = 'teachers';

    public const EXCLUDE_METHODS = ['store', 'destroy', 'update', 'show', 'restore', 'associate', 'dissociate'];

    public function alwaysIncludes(): array
    {
        return ['teachingSubjects'];
    }
}
