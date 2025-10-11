<?php

namespace App\Policies;

use App\Models\TargetShiftPagi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TargetShiftPagiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Target Shift Pagi');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TargetShiftPagi $targetShiftPagi): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Target Shift Pagi Create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TargetShiftPagi $targetShiftPagi): bool
    {
        return $user->can('Target Shift Pagi Edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TargetShiftPagi $targetShiftPagi): bool
    {
        return $user->can('Target Shift Pagi Delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TargetShiftPagi $targetShiftPagi): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TargetShiftPagi $targetShiftPagi): bool
    {
        return false;
    }
}
