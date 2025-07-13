<?php

namespace App\Services\Article\Contracts;

use App\Http\Requests\ArticleListingRequest;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleServiceInterface
{
    /**
     * Get all articles with optional filtering
     *
     * @param ArticleListingRequest|null $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(?ArticleListingRequest $request = null, int $perPage = 15): LengthAwarePaginator;

    /**
     * Get personalized articles for a user
     *
     * @param User|null $user
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPersonalized(?User $user = null, int $perPage = 15): LengthAwarePaginator;
}
