<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\Contracts\UserRepositoryInterface;
use App\Services\User\Actions\CreateUserAction;
use App\Services\User\Actions\GenerateTokenAction;
use App\Services\User\Actions\LoginUserAction;
use App\Services\User\Contracts\UserServiceInterface;
use App\Services\User\DTOs\CreateUserData;
use App\Services\User\DTOs\LoginUserData;
use Couchbase\AuthenticationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Passport\PersonalAccessTokenResult;

class UserService implements UserServiceInterface
{
    /**
     * @param CreateUserAction $createUser
     * @param GenerateTokenAction $generateToken
     * @param LoginUserAction $loginUser
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        protected CreateUserAction $createUser,
        protected GenerateTokenAction $generateToken,
        protected LoginUserAction $loginUser,
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @param CreateUserData $data
     * @return User
     */
    public function register(CreateUserData $data): User
    {
        $user = $this->createUser->handle($data);
        event(new Registered($user));

        return $user;
    }

    /**
     * @param LoginUserData $data
     * @return User
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function login(LoginUserData $data): User
    {
        return $this->loginUser->handle($data);
    }

    /**
     * @param User $user
     * @return PersonalAccessTokenResult
     */
    public function authenticate(User $user): PersonalAccessTokenResult
    {
        return $this->generateToken->handle($user);
    }

    /**
     * @return Authenticatable
     */
    public function getAuthenticatedUser(): Authenticatable
    {
        return $this->userRepository->getCurrentUser();
    }
}
