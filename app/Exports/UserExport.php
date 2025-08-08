<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::select('username', 'email', 'role')
            ->get()
            ->map(function ($user) {
                return [
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => ucfirst($user->role),
                ];
            });
    }

    public function headings(): array
    {
        return ['Username', 'Email', 'Role'];
    }
}
