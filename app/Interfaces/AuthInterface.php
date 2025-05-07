<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface AuthInterface
{
    public function login(Request $request): mixed;
    public function register(Request $request): mixed;
    public function logout(): mixed;
}
