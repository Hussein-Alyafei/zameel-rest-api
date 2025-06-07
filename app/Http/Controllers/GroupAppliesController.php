<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyRequest;
use App\Models\Apply;
use App\Models\Group;
use App\Models\Status;
use App\Policies\ApplyPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Orion\Http\Controllers\RelationController;

class GroupAppliesController extends RelationController
{
    protected $model = Group::class;

    protected $policy = ApplyPolicy::class;

    protected $relation = 'applies';

    protected $request = ApplyRequest::class;

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
        $attributes['user_id'] = Auth::user()->id;
        $attributes['group_id'] = $parentEntity->id;
        $attributes['status_id'] = Status::PENDING;
        $entity->fill($attributes);
    }

    public function filterableBy(): array
    {
        return [
            'user_id',
            'group_id',
            'status_id',
            'created_at',
            'updated_at',
        ];
    }

    public function accept(Request $request, Apply $apply)
    {
        Gate::allowIf(Gate::forUser(Auth::user())->any(['admin', 'manager', 'representer']));

        $apply->status_id = Status::ACCEPTED;
        $apply->save();

        $apply->group()->first()->members()->attach([$apply->user_id]);

        return response()->json(['message' => 'ok.']);
    }

    public function reject(Request $request, Apply $apply)
    {
        Gate::allowIf(Gate::forUser(Auth::user())->any(['admin', 'manager', 'representer']));

        $data = $request->validate(['note' => 'sometimes|string|max:255']);

        if (array_key_exists('note', $data)) {
            $apply->note = $data['note'];
        } else {
            $apply->note = null;
        }
        $apply->status_id = Status::REJECTED;
        $apply->save();

        return response()->json(['message' => 'ok.']);
    }
}
