<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Group;
use App\Policies\ApplyPolicy;
use App\Policies\MemberPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Orion\Http\Controllers\RelationController;

class GroupAppliesController extends RelationController
{
    protected $model = Group::class;

    protected $policy = ApplyPolicy::class;

    protected $relation = 'applies';

    public const EXCLUDE_METHODS = ['store', 'destroy', 'update', 'show', 'restore', 'attach', 'detach', 'sync', 'toggle', 'updatePivot'];

    protected function performFill(
        Request $request,
        Model $parentEntity,
        Model $entity,
        array $attributes,
        array $pivot
    ): void {
        $attributes['user_id'] = Auth::user()->id;
        $entity->fill($attributes);
    }
}
