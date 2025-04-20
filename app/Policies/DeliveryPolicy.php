<?php

namespace App\Policies;

use App\Models\Delivery;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class DeliveryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return Gate::forUser($user)->any(['admin', 'manager', 'academic']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Delivery $delivery): bool
    {
        return Gate::forUser($user)->any(['admin', 'manager', 'academic']) || $user->id === $delivery->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Gate::forUser($user)->any(['student', 'representer']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Delivery $delivery): bool
    {
        return Gate::forUser($user)->any(['admin']) || $user->id === $delivery->user_id;
    }
}
