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

        return $this->prepareUserTokenDto($user);
    }

    public function tokenFromUser(User $user): string
    {
        return $user->createToken('access_token')->plainTextToken;
    }

    public function registration(string $email, string $password): UserWithTokenDto
    {
        $user = $this->userService->create(
            email: $email,
            password: $password
        );

        return $this->prepareUserTokenDto($user);
    }

    private function prepareUserTokenDto(User $user): UserWithTokenDto
    {
        return new UserWithTokenDto(
            user: $user,
            token: $this->tokenFromUser($user),
        );
    }
}
