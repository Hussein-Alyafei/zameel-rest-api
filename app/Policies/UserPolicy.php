<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Gate::forUser($user)->any(['admin', 'manager']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return Gate::forUser($user)->any(['admin', 'manager']);
    }
}
