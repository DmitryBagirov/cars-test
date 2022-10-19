<?php

namespace Tests\Feature;

use App\Console\Commands\GenerateCarsCommand;
use App\Console\Commands\InitCarModelCommand;
use App\Models\Car;
use App\Models\User;
use App\Models\UserCar;
use App\Services\UserCarService;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserCarTest extends TestCase
{
    private User $user;
    private User $anotherUser;
    private UserCarService $userCarService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan(InitCarModelCommand::class);
        $this->artisan(GenerateCarsCommand::class);
        $this->userCarService = app(UserCarService::class);
        $this->user = User::factory()->create();
        $this->anotherUser = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function testCarsList(): void
    {
        $response = $this->get('/api/cars/');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'state_number',
                    'car_model' => [
                        'title',
                        'car_brand' => ['title']
                    ]
                ]
            ]
        ]);
    }

    public function testSwitchCar(): void
    {
        /** @var Car $car */
        $car = Car::query()->first();
        $response = $this->post("/api/cars/$car->id/switch");

        $response->assertNoContent();
        $this->assertDatabaseHas(UserCar::class, [
            'user_id' => $this->user->id,
            'car_id' => $car->id
        ]);
    }

    public function testSwitchDenied(): void
    {
        /** @var Car $car */
        $car = Car::query()->first();
        $this->userCarService->switch($this->anotherUser, $car);
        $response = $this->post("/api/cars/$car->id/switch");

        $response->assertForbidden();
    }

    public function testReleaseCar(): void
    {
        /** @var Car $car */
        $car = Car::query()->first();
        $this->userCarService->switch($this->user, $car);
        $response = $this->post('/api/cars/release');

        $response->assertNoContent();
        $this->assertDatabaseMissing(UserCar::class, [
            'user_id' => $this->user->id,
            'car_id' => $car->id
        ]);
    }
}
