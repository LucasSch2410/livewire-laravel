<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponses;
    public function login(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($payload)) {
            return $this->error('Invalid credentials.', 401);
        }

        $user = Auth::user();

        // Criar token após o login, com as permissões que desejar
        $token = $user->createToken('auth_token', ['server:update'])->plainTextToken;

        return $this->response('Logged in successfully.', 200, ['token' => $token]);
    }
}
