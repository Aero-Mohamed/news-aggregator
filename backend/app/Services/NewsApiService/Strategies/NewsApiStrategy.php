<?php

namespace App\Services\NewsApiService\Strategies;

use App\Services\NewsApiService\Abstracts\NewsSourceAbstract;
use App\Services\NewsApiService\Contracts\NewsSourceInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewsApiStrategy extends NewsSourceAbstract implements NewsSourceInterface
{
    protected Client $client;
    protected string $endpoint;
    protected string $apiKey;

    public function __construct()
    {
        $this->endpoint = config('services.newsapi.api_url');
        $this->apiKey = config('services.newsapi.api_key');

        $this->client = new Client([
            'base_uri' => $this->endpoint,
            'timeout'  => 10,
        ]);
    }

    /**
     * @return array
     */
    public function fetch(): array
    {
        try {
            $response = $this->client->request('GET', '', [
                'query' => [
                    'apiKey'   => $this->apiKey,
                    'language' => 'en',
                    'pageSize' => 50,
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            return $body['articles'] ?? [];
        } catch (\Throwable $e) {
            Log::error('NewsAPI fetch failed via Guzzle', [
                'message' => $e->getMessage(),
            ]);

            return [];
        }
    }

    /**
     * @param array $raw
     * @return array
     */
    public function transform(array $raw): array
    {
        return collect($raw)
            ->filter(fn ($article) => isset($article['url']))
            ->map(function ($article) {
                return [
                    'title'        => $article['title'] ?? null,
                    'author'       => $article['author'] ?? null,
                    'source'       => $article['source']['name'] ?? 'NewsAPI',
                    'url'          => $article['url'],
                    'url_hash'     => hash('sha256', $article['url']),
                    'slug'         => $this->getSlug($article),
                    'image_url'    => $article['urlToImage'] ?? null,
                    'description'  => $article['description'] ?? null,
                    'content'      => $article['content'] ?? null,
                    'published_at' => $article['publishedAt'] ?? now(),
                ];
            })->toArray();
    }

    /**
     * @param array $article
     * @return string
     */
    private function getSlug(array $article): string
    {
        $title = $article['title'];
        if (empty($title)) {
            $title = Str::uuid();
        }
        $title .= '-' . $article['source']['name'];
        return Str::slug($title);
    }
}
