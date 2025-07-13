<?php

namespace Tests\Unit;

use App\Http\Requests\ArticleListingRequest;
use App\Models\User;
use App\Repositories\Article\Contracts\ArticleRepositoryInterface;
use App\Services\Article\ArticleService;
use App\Services\User\Contracts\UserServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class ArticleServiceTest extends TestCase
{
    protected $userService;
    protected $articleRepository;
    protected $articleService;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock dependencies
        $this->userService = Mockery::mock(UserServiceInterface::class);
        $this->articleRepository = Mockery::mock(ArticleRepositoryInterface::class);

        $this->articleService = new ArticleService(
            $this->userService,
            $this->articleRepository
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_all_articles()
    {
        $paginator = new LengthAwarePaginator(
            [],
            0,
            15,
            1
        );

        $this->articleRepository
            ->shouldReceive('getAll')
            ->once()
            ->with(null, 15)
            ->andReturn($paginator);

        $result = $this->articleService->getAll(null, 15);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame($paginator, $result);
    }

    public function test_get_all_articles_with_request()
    {
        $request = Mockery::mock(ArticleListingRequest::class);

        $paginator = new LengthAwarePaginator(
            [],
            0,
            10,
            1
        );

        // Set up expectations for the repository mock
        $this->articleRepository
            ->shouldReceive('getAll')
            ->once()
            ->with($request, 10)
            ->andReturn($paginator);

        // Call the method being tested
        $result = $this->articleService->getAll($request, 10);

        // Assert the result is what we expect
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame($paginator, $result);
    }

    public function test_get_personalized_articles_with_provided_user()
    {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('getKey')->once()->andReturn('user-id-123');

        $paginator = new LengthAwarePaginator(
            [],
            0,
            15,
            1
        );

        $this->articleRepository
            ->shouldReceive('getPersonalized')
            ->once()
            ->with('user-id-123', 15)
            ->andReturn($paginator);

        $result = $this->articleService->getPersonalized($user, 15);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame($paginator, $result);
    }

    public function test_get_personalized_articles_with_authenticated_user()
    {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('getKey')->once()->andReturn('auth-user-id-456');

        $this->userService
            ->shouldReceive('getAuthenticatedUser')
            ->once()
            ->andReturn($user);

        $paginator = new LengthAwarePaginator(
            [],
            0,
            15,
            1
        );

        $this->articleRepository
            ->shouldReceive('getPersonalized')
            ->once()
            ->with('auth-user-id-456', 15)
            ->andReturn($paginator);

        $result = $this->articleService->getPersonalized(null, 15);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame($paginator, $result);
    }
}
