<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Film extends Model
{
    protected $table = 'film';

    protected $fillable = ['name', 'category_id', 'genres', 'year', 'director', 'producer', 'poster', 'background', 'logo', 'video', 'description', 'rating'];


    protected $casts = [
        'genres' => 'array',
    ];

    public function getGenresAttribute($value)
    {
        $ids = json_decode($value, true) ?? [];

        return Category::whereIn('id', $ids)->get();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getCategoryAttribute()
    {
        if (!$this->category_id) {
            return null;
        }

        return Category::find($this->category_id);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'film_id');
    }

    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'actor_film', 'film_id', 'actor_id')
            ->withTimestamps();
    }


}
