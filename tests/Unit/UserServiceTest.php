<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = app(UserService::class);
    }

    public function testCreate(): void
    {
        $email = 'email@example.com';
        $password = 'password';

        $user = $this->userService->create(
            email: $email,
            password: $password
        );

        $this->assertDatabaseHas(User::class, ['email' => $email]);
        $this->assertTrue(Hash::check($password, $user->password));
    }
}
