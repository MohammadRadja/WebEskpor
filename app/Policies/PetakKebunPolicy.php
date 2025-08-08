<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PetakKebun;

class PetakKebunPolicy
{
    /**
     * Semua role bisa lihat data.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    // public function view(User $user, PetakKebun $petakKebun)
    // {
    //     return in_array($user->role, ['owner', 'kepala_kebun']);
    // }
    public function view(User $user, PetakKebun $petakKebun)
    {
        return true;
    }

    /**
     * Hanya kepala kebun yang bisa menambah.
     */
    public function create(User $user)
    {
        return $user->role === 'manajer_kebun';
    }

    /**
     * Hanya kepala kebun yang bisa update.
     */
    public function update(User $user, PetakKebun $petakKebun)
    {
        return $user->role === 'manajer_kebun';
    }

    /**
     * Hanya kepala kebun yang bisa hapus.
     */
    public function delete(User $user, PetakKebun $petakKebun)
    {
        return $user->role === 'manajer_kebun';
    }
}
