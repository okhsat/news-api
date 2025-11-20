<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $fillable = [
        'source_id',
        'category_id',
        'title',
        'description',
        'content',
        'author',
        'url',
        'image_url',
        'published_at',
    ];

    protected $dates = ['published_at'];

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}