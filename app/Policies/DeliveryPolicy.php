<?php

namespace App\Policies;

use App\Models\Delivery;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DeliveryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_delivery")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can("create_delivery")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Delivery $delivery): bool
    {
        if ($user->can("edit_delivery")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Delivery $delivery): bool
    {
        if ($user->can("delete_delivery")) {
            return true;
        } else {
            return false;
        }
    }
}
