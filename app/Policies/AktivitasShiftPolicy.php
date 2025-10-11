<?php

namespace App\Policies;

use App\Models\AktivitasShift;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AktivitasShiftPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Aktivitas Shift');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AktivitasShift $aktivitasShift): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Aktivitas Shift Create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AktivitasShift $aktivitasShift): bool
    {
        return $user->can('Aktivitas Shift Edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AktivitasShift $aktivitasShift): bool
    {
        return $user->can('Aktivitas Shift Delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AktivitasShift $aktivitasShift): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AktivitasShift $aktivitasShift): bool
    {
        return false;
    }
}
