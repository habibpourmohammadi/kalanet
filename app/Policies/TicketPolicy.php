<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_ticket")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewMessages(User $user, Ticket $ticket): bool
    {
        if ($user->can("show_messages_ticket")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function sendMessage(User $user, Ticket $ticket): bool
    {
        if ($user->can("send_message_ticket")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function changeStatus(User $user, Ticket $ticket): bool
    {
        if ($user->can("change_status_ticket")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        if ($user->can("delete_ticket")) {
            return true;
        } else {
            return false;
        }
    }
}
