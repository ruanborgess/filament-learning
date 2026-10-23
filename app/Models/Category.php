<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

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
