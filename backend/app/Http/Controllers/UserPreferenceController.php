<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserPreferenceResource;
use App\Services\User\Contracts\UserServiceInterface;
use App\Services\User\DTOs\UserPreferenceData;
use Illuminate\Http\JsonResponse;

class UserPreferenceController extends Controller
{
    /**
     * @param UserServiceInterface $userService
     */
    public function __construct(
        protected UserServiceInterface $userService
    ) {
    }

    /**
     * Get user preferences
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $preferences = $this->userService->getUserPreferences();

        return $this->success(
            data: UserPreferenceResource::make($preferences),
        );
    }

    /**
     * Update user preferences
     *
     * @param UserPreferenceData $data
     * @return JsonResponse
     */
    public function update(UserPreferenceData $data): JsonResponse
    {
        $preferences = $this->userService->updateUserPreferences($data);

        return $this->success(
            data: UserPreferenceResource::make($preferences),
            message: 'Preferences updated',
        );
    }
}
