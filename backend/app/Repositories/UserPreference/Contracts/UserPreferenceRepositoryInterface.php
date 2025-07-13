<?php

namespace App\Repositories\UserPreference\Contracts;

use App\Models\UserPreference;
use App\Services\User\DTOs\UserPreferenceData;

interface UserPreferenceRepositoryInterface
{
    /**
     * Get user preferences by user ID
     *
     * @param string $userId
     * @return UserPreference|null
     */
    public function getByUserId(string $userId): ?UserPreference;

    /**
     * Create or update user preferences
     *
     * @param int $userId
     * @param UserPreferenceData $data
     * @return UserPreference
     */
    public function updateOrCreate(int $userId, UserPreferenceData $data): UserPreference;
}
