<?php

namespace App\Services\NewsApiService\Contracts;

interface NewsSourceInterface
{
    /**
     * @return array
     */
    public function fetch(): array;

    /**
     * @param array $raw
     * @return array
     */
    public function transform(array $raw): array;

    /**
     * @param array $articles
     * @return void
     */
    public function store(array $articles): void;
}
