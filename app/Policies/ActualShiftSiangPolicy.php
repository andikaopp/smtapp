<?php

namespace App\Policies;

use App\Models\ActualShiftSiang;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ActualShiftSiangPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Actual Shift Siang');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ActualShiftSiang $actualShiftSiang): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Actual Shift Siang Create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ActualShiftSiang $actualShiftSiang): bool
    {
        return $user->can('Actual Shift Siang Edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ActualShiftSiang $actualShiftSiang): bool
    {
        return $user->can('Actual Shift Siang Delete');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('Actual Shift Siang Delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ActualShiftSiang $actualShiftSiang): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ActualShiftSiang $actualShiftSiang): bool
    {
        return false;
    }
}
