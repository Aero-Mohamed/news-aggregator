<?php

namespace App\Repositories\Article\Contracts;

use App\Http\Requests\ArticleListingRequest;
use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
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
     * @param string $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPersonalized(string $userId, int $perPage = 15): LengthAwarePaginator;
}
