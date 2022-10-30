<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LoginController extends Controller
{
    public function login(Request $request): Response
    {
        $credentials = request(['email', 'password']);

        $user = User::where('email', '=', $credentials['email'])->first();

        if (!$user instanceof User) {
            return response(
                [
                    'status' => ResponseAlias::HTTP_NOT_FOUND,
                    'success' => false,
                    'data' => null
                ],
                ResponseAlias::HTTP_NOT_FOUND
            );
        }

        $role = 'user';

        if ($user->isAdmin()) {
            $role = 'admin';
        }

        if (!$token = auth()->claims(['role' => $role])->attempt($credentials)) {
            return response(
                [
                    'status' => ResponseAlias::HTTP_UNAUTHORIZED,
                    'success' => false,
                    'error' => 'Incorrect email/password'
                ]
            );
        }

        return $this->respondWithToken($token);
    }

    public function refresh(): Response
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token): Response
    {
        return response([
            'status' => ResponseAlias::HTTP_OK,
            'success' => true,
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        ]);
    }
}
