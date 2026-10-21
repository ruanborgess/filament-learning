<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory; 
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    
}
