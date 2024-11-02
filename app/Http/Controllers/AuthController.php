<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Criar token após o login
            $token = $user->createToken('token-name', ['server:update'])->plainTextToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }
}
