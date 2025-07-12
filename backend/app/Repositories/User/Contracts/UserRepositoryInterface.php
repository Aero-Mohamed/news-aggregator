<?php

namespace App\Repositories\User\Contracts;

use App\Models\User;
use App\Services\User\DTOs\CreateUserData;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Passport\Contracts\OAuthenticatable;

interface UserRepositoryInterface
{
    /**
     * Create a new user
     *
     * @param CreateUserData $data
     * @return User
     */
    public function create(CreateUserData $data): User;

    /**
     * Find user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * Find user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * Delete user tokens
     *
     * @param OAuthenticatable $user
     * @return void
     */
    public function deleteTokens(OAuthenticatable $user): void;

    /**
     * Get the currently authenticated user
     *
     * @return ?Authenticatable
     */
    public function getCurrentUser(): ?Authenticatable;
}
