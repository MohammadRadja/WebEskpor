<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Kebun;

class KebunPolicy
{
    /**
     * Semua user yang lolos middleware bisa lihat daftar kebun
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Semua user bisa lihat detail kebun
     */
    public function view(User $user, Kebun $kebun)
    {
        return true;
    }

    /**
     * Hanya manajer kebun yang boleh menambah kebun
     */
    public function create(User $user)
    {
        return $user->role === 'manajer_kebun';
    }

    /**
     * Hanya manajer kebun yang boleh mengubah kebun
     */
    public function update(User $user, Kebun $kebun)
    {
        return $user->role === 'manajer_kebun';
    }

    /**
     * Hanya manajer kebun yang boleh menghapus kebun
     */
    public function delete(User $user, Kebun $kebun)
    {
        return $user->role === 'manajer_kebun';
    }
}
