<?php

namespace App\Services;

use App\Models\CarModel;

class CarModelService
{
    public function findById(int $id): ?CarModel
    {
        return CarModel::query()->find($id);
    }
}
