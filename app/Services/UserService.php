<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(array $data): User
    {
        return User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role'      => $data['role'] ?? 'tutor',
            'branch_id' => $data['branch_id'] ?? null,
        ]);
    }

    public function updateUser(User $user, array $data): void
    {
        $updateData = [
            'name'      => $data['name'],
            'email'     => $data['email'],
            'branch_id' => $data['branch_id'] ?? $user->branch_id,
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);
    }
}
