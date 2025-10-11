<?php

namespace App\Policies;

use App\Models\KategoriAktivitasShift;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KategoriAktivitasShiftPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Kategori Aktivitas Shift');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, KategoriAktivitasShift $kategoriAktivitasShift): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Kategori Aktivitas Shift Create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, KategoriAktivitasShift $kategoriAktivitasShift): bool
    {
        return $user->can('Kategori Aktivitas Shift Edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KategoriAktivitasShift $kategoriAktivitasShift): bool
    {
        return $user->can('Kategori Aktivitas Shift Delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, KategoriAktivitasShift $kategoriAktivitasShift): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, KategoriAktivitasShift $kategoriAktivitasShift): bool
    {
        return false;
    }
}
