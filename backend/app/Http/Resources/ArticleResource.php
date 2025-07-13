<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method bool relationLoaded(string $relation)
 * @method mixed getRelation(string $relation)
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'            => $this['id'],
            'title'         => $this['title'],
            'slug'          => $this['slug'],
            'description'   => $this['description'],
            'content'       => $this['content'],
            'image_url'     => $this['image_url'],
            'url'           => $this['url'],
            'published_at'  => $this->getFormattedDate($this['published_at']),
        ];

        if ($this->relationLoaded('source')) {
            $data['source'] = SourceResource::make($this->getRelation('source'));
        }

        if ($this->relationLoaded('authors')) {
            $data['authors'] = AuthorResource::collection($this->getRelation('authors'));
        }

        if ($this->relationLoaded('categories')) {
            $data['categories'] = CategoryResource::collection($this->getRelation('categories'));
        }


        return $data;
    }

    /**
     * @param string $published_at
     * @return string|null
     */
    private function getFormattedDate(string $published_at): ?string
    {
        if (!empty($published_at)) {
            return Carbon::parse($published_at)->format('d M Y');
        }
        return null;
    }
}
