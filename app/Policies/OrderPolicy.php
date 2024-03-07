<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_order")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        if ($user->can("show_order")) {
            if ($user->hasRole("admin") || $order->products()->where("seller_id", $user->id)->count() != 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
