<?php

namespace App\Services\NewsApiService;

use App\Services\NewsApiService\Contracts\NewsSourceInterface;

class NewsApiService
{
    protected NewsSourceInterface $strategy;

    /**
     * @param NewsSourceInterface $strategy
     */
    public function __construct(NewsSourceInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @return void
     */
    public function sync(): void
    {
        $raw = $this->strategy->fetch();
        $normalized = $this->strategy->transform($raw);
        $this->strategy->store($normalized);
    }
}
