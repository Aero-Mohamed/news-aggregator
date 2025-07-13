<?php

namespace App\Repositories\UserPreference;

use App\Models\UserPreference;
use App\Repositories\UserPreference\Contracts\UserPreferenceRepositoryInterface;
use App\Services\User\DTOs\UserPreferenceData;

class UserPreferenceRepository implements UserPreferenceRepositoryInterface
{
    /**
     * Get user preferences by user ID
     *
     * @param string $userId
     * @return UserPreference|null
     */
    public function getByUserId(string $userId): ?UserPreference
    {
        return UserPreference::query()->where('user_id', $userId)->first();
    }

    /**
     * Create or update user preferences
     *
     * @param int $userId
     * @param UserPreferenceData $data
     * @return UserPreference
     */
    public function updateOrCreate(int $userId, UserPreferenceData $data): UserPreference
    {
        return UserPreference::query()->updateOrCreate(
            ['user_id' => $userId],
            [
                'source_ids' => $data->source_ids ?? [],
                'category_ids' => $data->category_ids ?? [],
                'author_ids' => $data->author_ids ?? [],
            ]
        );
    }
}
