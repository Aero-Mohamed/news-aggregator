<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\User\Contracts\UserRepositoryInterface;
use App\Services\User\Contracts\UserServiceInterface;
use App\Services\User\DTOs\CreateUserData;
use App\Services\User\DTOs\LoginUserData;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * @param UserServiceInterface $userService
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        protected UserServiceInterface $userService,
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @param LoginUserData $data
     * @return JsonResponse
     */
    public function login(LoginUserData $data): JsonResponse
    {
        $user = $this->userService->login($data);
        $token = $this->userService->authenticate($user);

        return $this->success(
            data: UserResource::make($user)->additional([
                'access_token' => $token->accessToken,
                'expires_in' => $token->expiresIn,
            ]),
        );
    }

    /**
     * @param CreateUserData $data
     * @return JsonResponse
     */
    public function register(CreateUserData $data): JsonResponse
    {
        $user = $this->userService->register($data);
        $token = $this->userService->authenticate($user);

        return $this->success(
            data: UserResource::make($user)->additional([
                'access_token' => $token->accessToken,
                'expires_in' => $token->expiresIn,
            ]),
        );
    }

    /**
     * @return JsonResponse
     */
    public function profile(): JsonResponse
    {
        /** @var User $user */
        $user = $this->userService->getAuthenticatedUser();

        return $this->success(
            data: UserResource::make($user),
        );
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->userService->logout();
        return $this->success();
    }
}
