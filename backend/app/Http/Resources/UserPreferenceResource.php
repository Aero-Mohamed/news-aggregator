<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPreferenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'source_ids' => $this['source_ids'] ?? [],
            'category_ids' => $this['category_ids'] ?? [],
            'author_ids' => $this['author_ids'] ?? [],
        ];
    }
}
