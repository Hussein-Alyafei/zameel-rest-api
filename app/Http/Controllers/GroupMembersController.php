<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GroupMembersController extends Controller
{
    public function index(Request $request, Group $group)
    {
        return response()->json(['data' => $group->members()->get()]);
    }

    public function attach(Request $request, Group $group, User $user)
    {
        // Gate::allowIf(Gate::forUser(Auth::user())->any(['admin', 'manager', 'representer']));
        $data = $request->validate(['is_representer' => 'sometimes|boolean']);

        $group->members()->attach($user->id, $data);

        return response()->json(['data' => $user], 201);
    }

    public function detach(Request $request, Group $group, User $user)
    {
        Gate::allowIf(Gate::forUser(Auth::user())->any(['admin', 'manager', 'representer']));

        $group->members()->detach([$user->id]);

        return response()->json(['data' => $user]);
    }

    public function update(Request $request, Group $group, User $user)
    {
        Gate::allowIf(Gate::forUser(Auth::user())->any(['admin', 'manager']));
        $data = $request->validate(['is_representer' => 'sometimes|boolean']);

        $group->members()->updateExistingPivot($user->id, $data);

        return response()->json(['data' => $user]);
    }
}
