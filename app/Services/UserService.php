<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(string $email, string $password): User
    {
        return User::query()
            ->create([
                'email' => $email,
                'password' => Hash::make($password),
            ]);
    }
}
