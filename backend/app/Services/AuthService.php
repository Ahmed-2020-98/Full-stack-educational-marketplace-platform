<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active',
        ]);

        $user->assignRole($data['role']);

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user->load('roles'),
            'token' => $token,
        ];
    }

    public function login(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = User::where('email', $credentials['email'])->firstOrFail();

        // Revoke all previous tokens
        $user->tokens()->delete();

        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user->load('roles'),
            'token' => $token,
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function profile(User $user): User
    {
        return $user->load('roles');
    }
}
