<?php

namespace Tests\Unit;

use App\Services\NewsApiService\Contracts\NewsSourceInterface;
use App\Services\NewsApiService\NewsApiService;
use Mockery;
use Tests\TestCase;

class NewsApiServiceTest extends TestCase
{
    protected NewsSourceInterface $strategy;
    protected NewsApiService $newsApiService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->strategy = Mockery::mock(NewsSourceInterface::class);

        $this->newsApiService = new NewsApiService($this->strategy);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_sync_calls_fetch_transform_and_store()
    {
        $rawData = [['raw' => 'article']];
        $transformedData = [['normalized' => 'article']];

        $this->strategy
            ->shouldReceive('fetch')
            ->once()
            ->andReturn($rawData);

        $this->strategy
            ->shouldReceive('transform')
            ->once()
            ->with($rawData)
            ->andReturn($transformedData);

        $this->strategy
            ->shouldReceive('store')
            ->once()
            ->with($transformedData);

        $this->newsApiService->sync();

        $this->assertTrue(true);
    }
}
