<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AuthRepository implements AuthInterface
{
    public function login(Request $request): array|null
    {
        try {
            $credentials = $request->validated();

            if (!$token = Auth::guard('api')->attempt($credentials)) {
                return null;
            }

            return $this->buildTokenResponse($token);

        } catch (\Exception $e) {
            Log::error('Login failed: ' . $e->getMessage());
            throw $e; 
        }
    }

    public function register(Request $request): array
    {
        try {
            $data = $request->validated();

            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $token = Auth::guard('api')->login($user);

            return $this->buildTokenResponse($token);
        } catch (\Exception $e) {
            Log::error('Register failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function logout(): bool
    {
        try {
            Auth::guard('api')->logout();
            return true;
        } catch (\Exception $e) {
            Log::error('Logout failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private function buildTokenResponse(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => Auth::guard('api')->factory()->getTTL() * 60,
        ];
    }
}

