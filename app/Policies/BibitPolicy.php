<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Bibit;

class BibitPolicy
{
    /**
     * Semua user yang lolos middleware bisa lihat daftar bibit
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Semua user bisa lihat detail bibit
     */
    public function view(User $user, Bibit $bibit)
    {
        return true;
    }

    /**
     * Hanya kepala kebun yang boleh menambah bibit
     */
    public function create(User $user)
    {
        return $user->role === 'manajer_kebun';
    }

    /**
     * Hanya kepala kebun yang boleh mengubah data bibit
     */
    public function update(User $user, Bibit $bibit)
    {
        return $user->role === 'manajer_kebun';
    }

    /**
     * Hanya kepala kebun yang boleh menghapus bibit
     */
    public function delete(User $user, Bibit $bibit)
    {
        return $user->role === 'manajer_kebun';
    }
}
