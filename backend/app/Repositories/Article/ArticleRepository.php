<?php

namespace App\Repositories\Article;

use App\Http\Requests\ArticleListingRequest;
use App\Models\Article;
use App\Models\User;
use App\Repositories\Article\Contracts\ArticleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * Get all articles with optional filtering using Spatie QueryBuilder
     *
     * @param ArticleListingRequest|null $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(?ArticleListingRequest $request = null, int $perPage = 15): LengthAwarePaginator
    {
        $keyword = $request?->input('keyword');

        return QueryBuilder::for(Article::class)
            ->allowedFilters([
                AllowedFilter::exact('source_id'),
                AllowedFilter::exact('authors.id'),
                AllowedFilter::exact('categories.id'),
                AllowedFilter::callback('date_from', function ($query, $value) {
                    $query->whereDate('published_at', '>=', $value);
                }),
                AllowedFilter::callback('date_to', function ($query, $value) {
                    $query->whereDate('published_at', '<=', $value);
                }),
            ])
            ->with(['categories', 'authors', 'source'])
            ->where(function ($query) use ($keyword) {
                if (empty($keyword)) {
                    return;
                }
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('content', 'like', "%{$keyword}%");
            })
            ->latest('published_at')
            ->paginate($perPage);
    }

    /**
     * Get personalized articles for a user
     *
     * @param string $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPersonalized(string $userId, int $perPage = 15): LengthAwarePaginator
    {
        $user = User::query()->findOrFail($userId);
        $preferences = $user->preferences;

        if (!$preferences) {
            // If no preferences, return all articles
            return $this->getAll(perPage: $perPage);
        }

        $query = QueryBuilder::for(Article::class);

        // Filter by preferred sources or categories or authors
        $query->where(function ($query) use ($preferences) {
            if (!empty($preferences->source_ids)) {
                $query->whereIn('source_id', $preferences->source_ids);
            }

            if (!empty($preferences->category_ids)) {
                $query->orWhereHas('categories', function ($query) use ($preferences) {
                    $query->whereIn('categories.id', $preferences->category_ids);
                });
            }

            if (!empty($preferences->author_ids)) {
                $query->orWhereHas('authors', function ($query) use ($preferences) {
                    $query->whereIn('authors.id', $preferences->author_ids);
                });
            }
        });

        return $query->with(['categories', 'authors', 'source'])
            ->latest()
            ->paginate($perPage);
    }
}
