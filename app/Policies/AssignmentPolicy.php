<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AssignmentPolicy
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
    public function view(User $user, Assignment $assignment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Gate::forUser($user)->any(['admin', 'representer', 'academic', 'manager']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Assignment $assignment): bool
    {
        return Gate::forUser($user)->any(['admin', 'representer', 'academic', 'manager']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Assignment $assignment): bool
    {
        return Gate::forUser($user)->any(['admin', 'representer', 'academic', 'manager']);
    }
}
