<?php

namespace App\Policies;

use App\Models\SampleTest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SampleTestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('SampleTest_access');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SampleTest $sampleTest): bool
    {
        return $user->hasPermission('SampleTest_show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('SampleTest_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SampleTest $sampleTest): bool
    {
        return $user->hasPermission('SampleTest_edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SampleTest $sampleTest): bool
    {
        return $user->hasPermission('SampleTest_delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SampleTest $sampleTest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SampleTest $sampleTest): bool
    {
        return false;
    }
}
