<?php

namespace App\Policies;

use App\Models\Slider;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SliderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_slider")) {
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
        if ($user->can("create_slider")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Slider $slider): bool
    {
        if ($user->can("edit_slider")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Slider $slider): bool
    {
        if ($user->can("delete_slider")) {
            return true;
        } else {
            return false;
        }
    }
}
