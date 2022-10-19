<?php

namespace App\Services\Car;

use App\Models\CarModel;

class CarListDto
{
    public function __construct(
        public readonly ?CarModel $carModel = null,
        public readonly ?int $perPage = null,
        public readonly ?int $page = null,
    ) {
    }
}
