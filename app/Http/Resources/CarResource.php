<?php

namespace App\Http\Resources;

use App\Models\Car;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Car $car */
        $car = $this->resource;

        return [
            'id' => $car->id,
            'state_number' => $car->state_number,
            'car_model' => CarModelResource::make($this->whenLoaded('carModel')),
        ];
    }
}
