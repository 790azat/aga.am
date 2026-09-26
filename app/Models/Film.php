<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Film extends Model
{
    protected $table = 'film';

    protected $fillable = ['name', 'category_id', 'genres', 'year', 'director', 'producer', 'poster', 'background', 'logo', 'video', 'description', 'rating'];

    /** @var array<string, Collection> */
    protected array $genresCache = [];

    protected $casts = [
        'genres' => 'array',
    ];

    /**
     * Жанры фильма (категории по id из JSON-поля genres).
     * Результат кэшируется в модели, чтобы не делать запрос при каждом обращении.
     */
    public function getGenresAttribute($value)
    {
        $ids = json_decode($value ?? '[]', true) ?? [];
        $key = implode(',', $ids);

        if (! isset($this->genresCache[$key])) {
            $this->genresCache = [$key => Category::whereIn('id', $ids)->get()];
        }

        return $this->genresCache[$key];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
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
