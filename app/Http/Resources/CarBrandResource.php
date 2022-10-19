<?php

namespace App\Http\Resources;

use App\Models\CarBrand;
use Illuminate\Http\Resources\Json\JsonResource;

class CarBrandResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var CarBrand $brand */
        $brand = $this->resource;

        return [
            'id' => $brand->id,
            'title' => $brand->title,
        ];
    }
}
