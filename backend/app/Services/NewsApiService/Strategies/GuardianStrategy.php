<?php

namespace App\Services\NewsApiService\Strategies;

use App\Services\NewsApiService\Contracts\NewsSourceInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GuardianStrategy implements NewsSourceInterface
{
    protected Client $client;
    protected string $endpoint;
    protected string $apiKey;

    public function __construct()
    {
        $this->endpoint = config('services.guardian.api_url');
        $this->apiKey = config('services.guardian.api_key');

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
                    'show-fields'  => 'headline,byline,thumbnail,bodyText',
                    'page-size'    => 50,
                    'order-by'     => 'newest',
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            return $body['response']['results'] ?? [];
        } catch (\Throwable $e) {
            Log::error('Guardian fetch failed via Guzzle', [
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
        return collect($raw)->map(function ($article) {
            return [
                'title'        => $article['webTitle'] ?? null,
                'author'       => $article['fields']['byline'] ?? null,
                'source'       => 'The Guardian',
                'url'          => $article['webUrl'] ?? null,
                'slug'         => Str::slug($article['webTitle'] ?? Str::uuid()),
                'image_url'    => $article['fields']['thumbnail'] ?? null,
                'description'  => null,
                'content'      => $article['fields']['bodyText'] ?? null,
                'published_at' => $article['webPublicationDate'] ?? now(),
            ];
        })->toArray();
    }

    /**
     * @param array $articles
     * @return void
     */
    public function store(array $articles): void
    {
        //
    }
}
