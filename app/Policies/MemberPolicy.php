<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class MemberPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Member $member): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Member $member): bool
    {
        return Gate::forUser($user)->any(['admin', 'manager']);
    }
}
