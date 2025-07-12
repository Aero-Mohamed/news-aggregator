<?php

namespace App\Services\User\Contracts;

use App\Models\User;
use App\Services\User\DTOs\CreateUserData;
use App\Services\User\DTOs\LoginUserData;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Passport\PersonalAccessTokenResult;

interface UserServiceInterface
{
    /**
     * @param CreateUserData $data
     * @return User
     */
    public function register(CreateUserData $data): User;

    /**
     * @param LoginUserData $data
     * @return User
     */
    public function login(LoginUserData $data): User;

    /**
     * @param User $user
     * @return PersonalAccessTokenResult
     */
    public function authenticate(User $user): PersonalAccessTokenResult;

    /**
     * @return Authenticatable
     */
    public function getAuthenticatedUser(): Authenticatable;
}
