<?php

namespace App\Services\NewsApiService\Strategies;

use App\Services\NewsApiService\Abstracts\NewsSourceAbstract;
use App\Services\NewsApiService\Contracts\NewsSourceInterface;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NYTimesStrategy extends NewsSourceAbstract implements NewsSourceInterface
{
    protected Client $client;
    protected string $endpoint;
    protected string $apiKey;

    public function __construct()
    {
        $this->endpoint = config('services.nytimes.api_url');
        $this->apiKey = config('services.nytimes.api_key');

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
                    'api-key'      => $this->apiKey,
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            return $body['results'] ?? [];
        } catch (\Throwable $e) {
            Log::error('NYTimes fetch failed via Guzzle', [
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
                'author'       => $article['byline'] ?? null,
                'source'       => 'New York Times',
                'categories'   => $this->getCategories($article),
                'url'          => $article['url'] ?? null,
                'url_hash'     => hash('sha256', $article['url']),
                'slug'         => Str::slug($article['title'] ?? Str::uuid()),
                'image_url'    => $this->extractImage($article['multimedia'] ?? []),
                'description'  => $article['abstract'] ?? null,
                'content'      => null,
                'published_at' => $article['published_date'] ?
                    Carbon::parse($article['published_date']) :  now(),
                ];
            })->toArray();
    }

    /**
     * @param array $media
     * @return string|null
     */
    protected function extractImage(array $media): ?string
    {
        foreach ($media as $item) {
            if (isset($item['url']) && in_array($item['type'], ['image', 'photo'])) {
                return $item['url'];
            }
        }

        return null;
    }

    /**
     * @param $article
     * @return array
     */
    private function getCategories($article): array
    {
        return collect([
            $article['section'],
            $article['subsection'],
        ])->filter(fn($cat) => !empty($cat))->toArray();
    }
}
