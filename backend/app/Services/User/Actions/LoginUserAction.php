<?php

namespace App\Services\User\Actions;

use App\Models\User;
use App\Repositories\User\Contracts\UserRepositoryInterface;
use App\Services\User\DTOs\LoginUserData;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\PersonalAccessTokenResult;

class LoginUserAction
{
    /**
     * @param GenerateTokenAction $generateTokenAction
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        protected GenerateTokenAction $generateTokenAction,
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @param LoginUserData $data
     * @return User
     * @throws AuthenticationException
     */
    public function handle(LoginUserData $data): User
    {
        if (!Auth::attempt($data->toArray())) {
            throw new AuthenticationException('Invalid credentials.');
        }

        /** @var User $user */
        $user = Auth::user();
        $this->userRepository->deleteTokens($user);

        return $user;
    }
}
