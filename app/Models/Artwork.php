<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'image_path',
        'share_count',
    ];

    protected $casts = [
        'share_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Users who liked this artwork
     */
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'artwork_likes')->withTimestamps();
    }

    /**
     * Users who saved this artwork
     */
    public function savedBy()
    {
        return $this->belongsToMany(User::class, 'artwork_saves')->withTimestamps();
    }
}
