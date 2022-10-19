<?php

namespace App\Http\Resources;

use App\Models\CarModel;
use Illuminate\Http\Resources\Json\JsonResource;

class CarModelResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var CarModel $carModel */
        $carModel = $this->resource;

        return [
            'id' => $carModel->id,
            'title' => $carModel->title,
            'car_brand_id' => $carModel->car_brand_id,
            'car_brand' => CarBrandResource::make($this->whenLoaded('carBrand')),
            'cars' => CarResource::collection($this->whenLoaded('cars'))
        ];
    }
}
