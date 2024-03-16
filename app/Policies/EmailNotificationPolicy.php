<?php

namespace App\Policies;

use App\Models\EmailNotification;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmailNotificationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_email")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EmailNotification $emailNotification): bool
    {
        if ($user->can("show_email")) {
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
        if ($user->can("create_email")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EmailNotification $emailNotification): bool
    {
        if ($user->can("edit_email")) {
            return true;
        } else {
            return false;
        }
    }

    public function send(User $user, EmailNotification $emailNotification): bool
    {
        if ($user->can("send_email")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EmailNotification $emailNotification): bool
    {
        if ($user->can("delete_email")) {
            return true;
        } else {
            return false;
        }
    }
}
