<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_user")) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->can("cahange_status_user")) {
            return true;
        } else {
            return false;
        }
    }
}
