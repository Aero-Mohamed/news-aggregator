<?php

namespace App\Services\NewsApiService\Abstracts;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Support\Collection;

abstract class NewsSourceAbstract
{
    /**
     * @param array $articles
     * @return void
     */
    public function store(array $articles): void
    {
        foreach ($articles as $data) {
            if (empty($data['url'])) {
                continue;
            }

            $source = Source::query()->firstOrCreate(['name' => $data['source']]);

            $authors = null;
            if (!empty($data['author'])) {
                $authors = $this->getAuthors($data['author']);
            }

            // Store article
            $article = Article::query()->updateOrCreate(
                ['url_hash' => $data['url_hash']],
                [
                    'source_id'    => $source->id,
                    'title'        => $data['title'],
                    'slug'         => $data['slug'],
                    'description'  => $data['description'],
                    'content'      => $data['content'],
                    'url'          => $data['url'],
                    'image_url'    => $data['image_url'],
                    'published_at' => Carbon::parse($data['published_at']),
                ]
            );

            if (empty($data['categories'])) {
                $category = Category::query()->firstOrCreate(['name' => 'General']);
                $categories = [$category->id];
            } else {
                $categories = collect($data['categories'])->map(function ($categoryName) {
                    return Category::query()->firstOrCreate(['name' => $categoryName]);
                })->pluck('id');
            }

            $article->categories()->syncWithoutDetaching($categories);

            if ($authors && $authors->isNotEmpty()) {
                $article->authors()->syncWithoutDetaching($authors->pluck('id'));
            }
        }
    }

    /**
     * @param string $authors
     * @return Collection
     */
    private function getAuthors(string $authors): Collection
    {
        $data = explode(',', $authors);
        return collect($data)->map(function ($author) {
            $author = trim($author);
            if (preg_match('/^by\s+/i', $author)) {
                $author = preg_replace('/^by\s+/i', '', $author);
            }

            return Author::query()->firstOrCreate(['name' => $author]);
        });
    }
}
