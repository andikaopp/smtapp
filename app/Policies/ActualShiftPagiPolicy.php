<?php

namespace App\Policies;

use App\Models\ActualShiftPagi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ActualShiftPagiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Actual Shift Pagi');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ActualShiftPagi $actualShiftPagi): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Actual Shift Pagi Create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ActualShiftPagi $actualShiftPagi): bool
    {
        return $user->can('Actual Shift Pagi Edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ActualShiftPagi $actualShiftPagi): bool
    {
        return $user->can('Actual Shift Pagi Delete');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('Actual Shift Pagi Delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ActualShiftPagi $actualShiftPagi): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ActualShiftPagi $actualShiftPagi): bool
    {
        return false;
    }
}
