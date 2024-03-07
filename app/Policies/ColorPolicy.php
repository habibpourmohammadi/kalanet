<?php

namespace App\Policies;

use App\Models\Color;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ColorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_color")) {
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
        if ($user->can("create_color")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Color $color): bool
    {
        if ($user->can("edit_color")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Color $color): bool
    {
        if ($user->can("delete_color")) {
            return true;
        } else {
            return false;
        }
    }
}
