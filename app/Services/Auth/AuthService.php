<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\LoginedUserDto;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function login(string $email, string $password): ?UserWithTokenDto
    {
        $user = $this->userService->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }

        $token = $this->tokenFromUser($user);

        return new UserWithTokenDto(user: $user, token: $token);
    }

    public function tokenFromUser(User $user): string
    {
        return $user->createToken('access_token')->plainTextToken;
    }
}
