<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\UserPreference;
use App\Repositories\User\Contracts\UserRepositoryInterface;
use App\Repositories\UserPreference\Contracts\UserPreferenceRepositoryInterface;
use App\Services\User\Actions\CreateUserAction;
use App\Services\User\Actions\GenerateTokenAction;
use App\Services\User\Actions\LoginUserAction;
use App\Services\User\Actions\LogoutUserAction;
use App\Services\User\Contracts\UserServiceInterface;
use App\Services\User\DTOs\CreateUserData;
use App\Services\User\DTOs\LoginUserData;
use App\Services\User\DTOs\UserPreferenceData;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Passport\PersonalAccessTokenResult;

class UserService implements UserServiceInterface
{
    /**
     * @param CreateUserAction $createUser
     * @param GenerateTokenAction $generateToken
     * @param LoginUserAction $loginUser
     * @param LogoutUserAction $logoutUser
     * @param UserRepositoryInterface $userRepository
     * @param UserPreferenceRepositoryInterface $userPreferenceRepository
     */
    public function __construct(
        protected CreateUserAction $createUser,
        protected GenerateTokenAction $generateToken,
        protected LoginUserAction $loginUser,
        protected LogoutUserAction $logoutUser,
        protected UserRepositoryInterface $userRepository,
        protected UserPreferenceRepositoryInterface $userPreferenceRepository,
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
     * @return ?Authenticatable
     */
    public function getAuthenticatedUser(): ?Authenticatable
    {
        return $this->userRepository->getCurrentUser();
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        if ($user = $this->getAuthenticatedUser()) {
            $this->logoutUser->handler($user);
        }
    }

    /**
     * @param User|null $user
     * @return UserPreference|null
     */
    public function getUserPreferences(?User $user = null): ?UserPreference
    {
        if (empty($user)) {
            $user = $this->getAuthenticatedUser();
        }

        return $this->userPreferenceRepository->getByUserId($user->getKey());
    }

    /**
     * @param UserPreferenceData $data
     * @param User|null $user
     * @return UserPreference
     */
    public function updateUserPreferences(UserPreferenceData $data, ?User $user = null): UserPreference
    {
        if (empty($user)) {
            $user = $this->getAuthenticatedUser();
        }

        return $this->userPreferenceRepository->updateOrCreate($user->getKey(), $data);
    }
}
