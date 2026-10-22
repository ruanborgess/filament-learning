<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'thumbnail',
        'thumbnail_url',
        'tags',
        'published',
    ];

    protected $casts = [
        'tags' => 'array',
        'published' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_post')
            ->withPivot('order')
            ->orderBy('user_post.order');
    }

}
