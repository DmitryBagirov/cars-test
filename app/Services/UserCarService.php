<?php

namespace App\Services;

use App\Models\Car;
use App\Models\User;
use App\Models\UserCar;

class UserCarService
{
    /**
     * Release the current car and use the provided
     *
     * @param User $user
     * @param Car $car
     * @return void
     */
    public function switch(User $user, Car $car): void
    {
        $user->userCar()->updateOrCreate([
            'user_id' => $user->id,
            'car_id' => $car->id
        ]);
    }

    /**
     * Release the current car
     *
     * @param User $user
     * @return void
     */
    public function release(User $user): void
    {
        $user->userCar()->delete();
    }

    public function canUse(Car $car, User $user): bool
    {
        return !UserCar::query()
            ->whereNot('user_id', $user->id)
            ->where('car_id', $car->id)
            ->exists();
    }
}
