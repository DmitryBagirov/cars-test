<?php

namespace App\Services\Car;

use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CarService
{
    public function create(CarModel $carModel, string $stateNumber): Car
    {
        return Car::query()->create([
            'state_number' => $stateNumber,
            'car_model_id' => $carModel->id,
        ]);
    }

    public function list(CarListDto $dto): LengthAwarePaginator
    {
        return Car::query()
            ->with('carModel.carBrand')
            ->when($dto->carModel, fn(Builder $b) => $b->forModel($dto->carModel))
            ->whereDoesntHave(
                'userCar',
                fn(Builder $b) => $b->whereNotNull('user_id')
            )
            ->paginate(
                perPage: $dto->perPage,
                page: $dto->page
            );
    }
}
