<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function store(array $payload): bool
    {
        $payload['password'] = bcrypt($payload['password']);

        $newUser = User::create($payload);

        return ($newUser !== null);
    }

    public function login(array $payload)
    {
        $token = null;
        if (Auth::attempt($payload)) {
            $user = User::where('email', $payload['email'])->first();

            $token = $user->createToken($user->email)->plainTextToken;
        }
        return $token;
    }
}
