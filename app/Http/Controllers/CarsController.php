<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarsListRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Services\Car\CarListDto;
use App\Services\Car\CarService;
use App\Services\UserCarService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class CarsController extends Controller
{
    public function __construct(
        private readonly CarService $carService,
        private readonly UserCarService $userCarService
    ) {
    }

    public function index(CarsListRequest $request): JsonResource
    {
        $cars = $this->carService->list(
            new CarListDto(
                carModel: $request->car_model,
                perPage: $request->per_page,
                page: $request->page,
            ));

        return CarResource::collection($cars);
    }

    /**
     * @throws AuthorizationException
     */
    public function switch(Car $car): Response
    {
        $this->authorize('canUseCar', $car);

        $this->userCarService->switch(
            user: $this->getAuthenticatedUser(),
            car: $car,
        );

        return response()->noContent();
    }

    public function release(): Response
    {
        $this->userCarService->release($this->getAuthenticatedUser());

        return response()->noContent();
    }
}
