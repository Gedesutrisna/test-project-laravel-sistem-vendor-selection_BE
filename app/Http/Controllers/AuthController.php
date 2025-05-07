<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\AuthInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        protected readonly AuthInterface $auth
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $this->auth->login($request);

            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email atau password salah',
                    'data' => null
                ], Response::HTTP_UNAUTHORIZED);
            }

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'data' => $data
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat login',
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $this->auth->register($request);
            return response()->json([
                'status' => true,
                'message' => 'Registration successful',
                'data' => $data
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat registrasi',
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->auth->logout();
            return response()->json([
                'status' => true,
                'message' => 'Logout successful',
                'data' => null
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal logout',
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
