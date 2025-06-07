<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyRequest;
use App\Http\Requests\AssignmentRequest;
use App\Models\Apply;
use App\Models\Group;
use App\Models\Status;
use App\Policies\ApplyPolicy;
use App\Policies\AssignmentPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Orion\Http\Controllers\RelationController;

class GroupAssignmentsController extends RelationController
{
    protected $model = Group::class;

    protected $policy = AssignmentPolicy::class;

    protected $relation = 'assignments';

    protected $request = AssignmentRequest::class;

    public const EXCLUDE_METHODS = ['update', 'restore', 'associate', 'dissociate'];

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
        return [ ];
    }

}
