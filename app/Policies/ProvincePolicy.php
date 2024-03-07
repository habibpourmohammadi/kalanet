<?php

namespace App\Policies;

use App\Models\Province;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProvincePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_province")) {
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
        if ($user->can("create_province")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Province $province): bool
    {
        if ($user->can("edit_province")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Province $province): bool
    {
        if ($user->can("delete_province")) {
            return true;
        } else {
            return false;
        }
    }
}
