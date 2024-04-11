<?php

namespace App\Policies;

use App\Models\SellerRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BecomeSellerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_become_a_seller_messages")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SellerRequest $sellerRequest): bool
    {
        if ($user->can("show_become_a_seller_messages")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SellerRequest $sellerRequest): bool
    {
        if ($user->can("delete_become_a_seller_messages")) {
            return true;
        } else {
            return false;
        }
    }

    public function changeSeenStatus(User $user, SellerRequest $sellerRequest): bool
    {
        if ($user->can("change_seen_status_become_a_seller_messages")) {
            return true;
        } else {
            return false;
        }
    }

    public function changeApprovalStatus(User $user, SellerRequest $sellerRequest): bool
    {
        if ($user->can("change_approval_status_become_a_seller_messages")) {
            return true;
        } else {
            return false;
        }
    }
}
