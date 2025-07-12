<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasUuids;

    protected $guarded = [];

    /**
     * The categories that belong to the article.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)
            ->using(ArticleCategory::class)
            ->withTimestamps();
    }
}
