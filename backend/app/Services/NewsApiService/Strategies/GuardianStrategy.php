<?php

namespace App\Services\NewsApiService\Strategies;

use App\Services\NewsApiService\Abstracts\NewsSourceAbstract;
use App\Services\NewsApiService\Contracts\NewsSourceInterface;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GuardianStrategy extends NewsSourceAbstract implements NewsSourceInterface
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
        return collect($raw)
            ->filter(fn ($article) => isset($article['webUrl']))
            ->map(function ($article) {
                return [
                'title'        => $article['webTitle'] ?? null,
                'author'       => $article['fields']['byline'] ?? null,
                'source'       => 'The Guardian',
                'categories'   => $this->getCategories($article),
                'url'          => $article['webUrl'],
                'url_hash'     => hash('sha256', $article['webUrl']),
                'slug'         => $this->getSlug($article),
                'image_url'    => $article['fields']['thumbnail'] ?? null,
                'description'  => null,
                'content'      => $article['fields']['bodyText'] ?? null,
                'published_at' => $article['webPublicationDate'] ?
                    Carbon::parse($article['webPublicationDate']) :  now(),
                ];
            })->toArray();
    }

    /**
     * @param array $article
     * @return string
     */
    private function getSlug(array $article): string
    {
        $title = $article['webTitle'];
        if (empty($title)) {
            $title = Str::uuid();
        }
        $title .= '-The Guardian';
        return Str::slug($title);
    }

    /**
     * @param $article
     * @return array
     */
    private function getCategories($article): array
    {
        return collect([
            $article['sectionName'],
            $article['pillarName'],
        ])->filter(fn($cat) => !empty($cat))->toArray();
    }
}
