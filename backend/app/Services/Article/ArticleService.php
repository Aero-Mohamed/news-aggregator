<?php

namespace App\Services\Article;

use App\Http\Requests\ArticleListingRequest;
use App\Models\User;
use App\Repositories\Article\Contracts\ArticleRepositoryInterface;
use App\Services\Article\Contracts\ArticleServiceInterface;
use App\Services\User\Contracts\UserServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService implements ArticleServiceInterface
{
    /**
     * @param UserServiceInterface $userService
     * @param ArticleRepositoryInterface $articleRepository
     */
    public function __construct(
        protected UserServiceInterface $userService,
        protected ArticleRepositoryInterface $articleRepository
    ) {
    }

    /**
     * Get all articles with optional filtering using Spatie QueryBuilder
     *
     * @param ArticleListingRequest|null $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(?ArticleListingRequest $request = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->articleRepository->getAll($request, $perPage);
    }

    /**
     * Get personalized articles for a user
     *
     * @param User|null $user
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPersonalized(?User $user = null, int $perPage = 15): LengthAwarePaginator
    {
        if (empty($user)) {
            $user = $this->userService->getAuthenticatedUser();
        }
        return $this->articleRepository->getPersonalized($user->getKey(), $perPage);
    }
}
