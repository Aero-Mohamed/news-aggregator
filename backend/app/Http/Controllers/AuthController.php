<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            /** @var User $user */
            $user = Auth::user();

            // Revoke all previous tokens
            $user->tokens()->delete();
            $token = $user->createToken('API Token');
            return $this->success(
                data: [
                    'access_token' => $token->accessToken,
                    'expires_in' => $token->expiresIn
                ]
            );
        }

        return $this->error(
            message: 'Wrong email or password',
            statusCode: self::$responseCode::HTTP_BAD_REQUEST
        );
    }
}
