<?php

namespace App\Policies;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InventoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('Inventory_access');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Inventory $inventory): bool
    {
        return $user->hasPermission('Inventory_show');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('Inventory_create');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Inventory $inventory): bool
    {
        return $user->hasPermission('Inventory_edit');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Inventory $inventory): bool
    {
        return $user->hasPermission('Inventory_delete');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Inventory $inventory): bool
    {
        return false;

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Inventory $inventory): bool
    {
        return false;

    }
}
