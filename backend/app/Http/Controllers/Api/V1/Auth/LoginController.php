<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;

class LoginController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function __invoke(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        return $this->successResponse(
            data: [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ],
            message: 'Login successful.'
        );
    }
}
