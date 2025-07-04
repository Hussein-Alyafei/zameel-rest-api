<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PromotionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user, Role $role)
    {
        Gate::allowIf($user->id !== 1);
        if ($role->id >= Role::MANAGER || $user->role_id >= Role::MANAGER) {
            Gate::allowIf(Gate::forUser(Auth::user())->check('admin'));
        } else {
            Gate::allowIf(Gate::forUser(Auth::user())->any(['admin', 'manager']));
        }

        $user->role_id = $role->id;
        $user->save();

        return response()->json(['data' => $user->toArray()]);
    }
}
