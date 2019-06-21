<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Service\AuthService\AuthServiceInterface;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(AuthServiceInterface $auth_service)
    {
        $credentials = request(['student_id', 'password']);
        $token = $auth_service->login($credentials);

        if (! $token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function userInfo(AuthServiceInterface $auth_service)
    {
        return response()->json($auth_service->userInfo());
    }

    public function logout(AuthServiceInterface $auth_service)
    {
        $auth_service->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(AuthServiceInterface $auth_service)
    {
        return $this->respondWithToken($auth_service->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 24 * 30
        ]);
    }


}
