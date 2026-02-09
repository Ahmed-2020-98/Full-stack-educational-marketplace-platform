<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;

class RegisterController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function __invoke(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        return $this->successResponse(
            data: [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ],
            message: 'Registration successful.',
            statusCode: 201
        );
    }
}
