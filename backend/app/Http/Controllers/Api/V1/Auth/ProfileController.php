<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function show(Request $request)
    {
        $user = $this->authService->profile($request->user());

        return $this->successResponse(
            data: new UserResource($user),
            message: 'Profile retrieved successfully.'
        );
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->successResponse(
            message: 'Logged out successfully.'
        );
    }
}
