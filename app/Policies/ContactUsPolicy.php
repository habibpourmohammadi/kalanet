<?php

namespace App\Policies;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContactUsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_contact_us_messages")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContactMessage $contactMessage): bool
    {
        if ($user->can("show_contact_us_messages")) {
            return true;
        } else {
            return false;
        }
    }

    public function changeStatus(User $user, ContactMessage $contactMessage): bool
    {
        if ($user->can("change_status_contact_us_messages")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContactMessage $contactMessage): bool
    {
        if ($user->can("delete_contact_us_messages")) {
            return true;
        } else {
            return false;
        }
    }
}
