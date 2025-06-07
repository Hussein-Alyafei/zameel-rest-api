<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GroupTeachersController extends Controller
{
        public function index(Request $request, Group $group) {
            $data = $group->teachers()->get();
            foreach ($data as $row) {
                $row->subject = Subject::find($row->pivot->subject_id);
            }
        return response()->json(['data' => $data]);
    }

    public function attach(Request $request, Group $group, User $user) {
        Gate::allowIf(Gate::forUser(Auth::user())->any(['admin', 'manager' ]));
        $data = $request->validate(['subject_id' => 'required|integer|numeric|exists:subjects,id']);

        $group->teachers()->attach($user->id, $data);
        return response()->json(['data' => $user], 201);
    }
    
    public function detach(Request $request, Group $group, User $user) {
        Gate::allowIf(Gate::forUser(Auth::user())->any(['admin', 'manager']));

        $group->teachers()->detach([$user->id]);
        return response()->json(['data' => $user]);
    }
}
