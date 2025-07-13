<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleListingRequest;
use App\Http\Resources\ArticleResource;
use App\Services\Article\Contracts\ArticleServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * @var ArticleServiceInterface
     */
    private ArticleServiceInterface $articleService;

    /**
     * ArticleController constructor.
     *
     * @param ArticleServiceInterface $articleService
     */
    public function __construct(ArticleServiceInterface $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Get all articles with optional filtering
     *
     * @param ArticleListingRequest $request
     * @return JsonResponse
     */
    public function index(ArticleListingRequest $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);

        $articles = $this->articleService->getAll($request, $perPage);

        return $this->success(
            data: ArticleResource::collection($articles)
        );
    }

    /**
     * Get personalized articles for the authenticated user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function personalized(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);

        $articles = $this->articleService->getPersonalized(perPage: $perPage);

        return $this->success(
            data: ArticleResource::collection($articles)
        );
    }
}
