<?php

namespace App\Policies;

use App\Models\Guarantee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GuaranteePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_guarantee")) {
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
        if ($user->can("create_guarantee")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Guarantee $guarantee): bool
    {
        if ($user->can("edit_guarantee")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Guarantee $guarantee): bool
    {
        if ($user->can("delete_guarantee")) {
            return true;
        } else {
            return false;
        }
    }
}
