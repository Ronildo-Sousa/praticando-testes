<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $stored = (new AuthService())->store($request->validated());

        if ($stored) {
            return response()->json(['message' => 'User created successfully.'], Response::HTTP_CREATED);
        }
        return response()->json(['message' => 'Cannot create user.'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function login(LoginRequest $request)
    {
        $userToken = (new AuthService())->login($request->validated());

        if ($userToken) {
            return response()->json([
                "message" => "User logged in successfully.",
                "bearer_token" => $userToken
            ], Response::HTTP_OK);
        }
        return response()->json(['message' => 'The credentials not matches.'], Response::HTTP_UNAUTHORIZED);
    }
}
