<?php

namespace Tests\Unit;

use App\Console\Commands\GenerateCarsCommand;
use App\Console\Commands\InitCarModelCommand;
use App\Models\Car;
use App\Models\User;
use App\Models\UserCar;
use App\Services\UserCarService;
use Tests\TestCase;

class UserCarServiceTest extends TestCase
{
    private UserCarService $userCarService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan(InitCarModelCommand::class);
        $this->artisan(GenerateCarsCommand::class);
        $this->userCarService = app(UserCarService::class);
    }

    public function testSwitchCar(): void
    {
        $car = Car::first();
        $user = User::factory()->create();

        $this->userCarService->switch($user, $car);

        $this->assertDatabaseHas(UserCar::class, [
            'user_id' => $user->id,
            'car_id' => $car->id
        ]);
    }

    public function testReleaseCar(): void
    {
        $car = Car::first();
        $user = User::factory()->create();

        UserCar::query()->create([
            'user_id' => $user->id,
            'car_id' => $car->id,
        ]);

        $this->userCarService->release($user);

        $this->assertDatabaseMissing(UserCar::class, [
            'user_id' => $user->id,
            'car_id' => $car->id
        ]);
    }
}
