<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\Contracts\UserRepositoryInterface;
use App\Services\User\DTOs\CreateUserData;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create a new user
     *
     * @param CreateUserData $data
     * @return User
     */
    public function create(CreateUserData $data): User
    {
        return User::query()->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
    }

    /**
     * Find user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }

    /**
     * Find user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return User::query()->find($id);
    }

    /**
     * Delete user tokens
     *
     * @param User $user
     * @return void
     */
    public function deleteTokens(User $user): void
    {
        $user->tokens()->delete();
    }

    /**
     * Get the currently authenticated user
     *
     * @return ?Authenticatable
     */
    public function getCurrentUser(): ?Authenticatable
    {
        return Auth::user();
    }
}
