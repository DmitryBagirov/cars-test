<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    public function registration(RegistrationRequest $request): Response
    {
        $userWihTokenDto = $this->authService->registration(
            email: $request->email,
            password: $request->password,
        );

        return response()->json([
            'user' => UserResource::make($userWihTokenDto->user),
            'token' => $userWihTokenDto->token,
        ]);
    }

    public function login(LoginRequest $request): Response
    {
        $userWihTokenDto = $this->authService->login(
            email: $request->email,
            password: $request->password
        );

        if (!$userWihTokenDto) {
            return response()->json(
                [
                    'message' => trans('auth.failed'),
                    'errors' => [
                        'password' => [trans('auth.failed')]
                    ]
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        return response()->json([
            'user' => UserResource::make($userWihTokenDto->user),
            'token' => $userWihTokenDto->token,
        ]);
    }

    public function me(): JsonResource
    {
        $user = $this->getAuthenticatedUser();

        return UserResource::make($user->load('car.carModel.carBrand'));
    }
}
