<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentRequest;
use App\Models\Group;
use App\Policies\AssignmentPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Orion\Http\Controllers\RelationController;

class GroupAssignmentsController extends RelationController
{
    protected $model = Group::class;

    protected $policy = AssignmentPolicy::class;

    protected $relation = 'assignments';

    protected $request = AssignmentRequest::class;

    public const EXCLUDE_METHODS = ['store', 'update', 'restore', 'associate', 'dissociate'];

    public function alwaysIncludes(): array
    {
        return ['user'];
    }

    protected function performFill(
        Request $request,
        Model $parentEntity,
        Model $entity,
        array $attributes,
        array $pivot
    ): void {
        $attributes['group_id'] = $parentEntity->id;
        $entity->fill($attributes);
    }

    public function filterableBy(): array
    {
        return ['due_date', 'subject_id', 'group_id', 'created_at'];
    }
}
