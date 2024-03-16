<?php

namespace App\Policies;

use App\Models\GeneralDiscount;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GeneralDiscountPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_general_discount")) {
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
        if ($user->can("create_general_discount")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GeneralDiscount $generalDiscount): bool
    {
        if ($user->can("edit_general_discount")) {
            return true;
        } else {
            return false;
        }
    }

    public function changeStatus(User $user, GeneralDiscount $generalDiscount): bool
    {
        if ($user->can("change_status_general_discount")) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GeneralDiscount $generalDiscount): bool
    {
        if ($user->can("delete_general_discount")) {
            return true;
        } else {
            return false;
        }
    }
}
