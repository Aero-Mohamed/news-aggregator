<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasUuids;

    protected $guarded = [];

    /**
     * The articles that belong to the category.
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class)
            ->using(ArticleCategory::class);
    }
}
