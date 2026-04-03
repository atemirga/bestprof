<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'type', 'excerpt', 'content',
        'image', 'is_published', 'published_at', 'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->where('published_at', '<=', now());
    }

    public function scopeNews($query)
    {
        return $query->where('type', 'news');
    }

    public function scopeBlog($query)
    {
        return $query->where('type', 'blog');
    }
}
