<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;
use App\Services\UserCarService;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarPolicy
{
    use HandlesAuthorization;

    public function __construct(private UserCarService $userCarService)
    {
    }

    public function canUseCar(User $user, Car $car): bool
    {
        return $this->userCarService->canUse($car, $user);
    }
}
