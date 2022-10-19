<?php

namespace App\Services\Auth;

use App\Models\User;

class UserWithTokenDto
{
    public function __construct(
        public readonly User $user,
        public readonly string $token,
    ) {
    }
}
