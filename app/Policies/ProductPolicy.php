<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can("show_product")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        if ($user->can("show_product")) {
            if ($user->hasRole("admin") || $product->seller_id === $user->id) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can("create_product")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        if ($user->can("edit_product")) {
            if ($user->hasRole("admin") || $product->seller_id === $user->id) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        if ($user->can("delete_product")) {
            if ($user->hasRole("admin") || $product->seller_id === $user->id) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
