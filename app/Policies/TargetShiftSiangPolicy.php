<?php

namespace App\Policies;

use App\Models\TargetShiftSiang;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TargetShiftSiangPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Target Shift Siang');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TargetShiftSiang $targetShiftSiang): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Target Shift Siang Create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TargetShiftSiang $targetShiftSiang): bool
    {
        return $user->can('Target Shift Siang Edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TargetShiftSiang $targetShiftSiang): bool
    {
        return $user->can('Target Shift Siang Delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TargetShiftSiang $targetShiftSiang): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TargetShiftSiang $targetShiftSiang): bool
    {
        return false;
    }
}
