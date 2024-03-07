<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function index(User $user): bool
    {
        if (!$user->can("show_permission")) {
            return false;
        }

        return true;
    }
}
