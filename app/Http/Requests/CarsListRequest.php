<?php

namespace App\Http\Requests;

use App\Models\CarModel;
use App\Services\CarModelService;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property CarModel|null $car_model
 * @property int|null $page
 * @property int|null $per_page
 */
class CarsListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'car_model' => 'nullable|int|exists:car_models,id',
            'page' => 'nullable|int|min:1',
            'per_page' => 'nullable|int|min:1',
        ];
    }

    public function passedValidation(): void
    {
        /** @var CarModelService $carModelService */
        $carModelService = app(CarModelService::class);

        $this->merge([
            'car_model' => $this->car_model ? $carModelService->findById($this->input('car_model')) : null
        ]);
    }
}
