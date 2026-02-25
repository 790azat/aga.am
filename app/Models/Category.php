<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    // Можно явно указать таблицу (не обязательно, т.к. Laravel сам использует 'categories')
    protected $table = 'categories';

    // Разрешённые для массового заполнения поля
    protected $fillable = ['name'];

    /**
     * Связь с фильмами.
     * Одна категория может иметь много фильмов.
     */
    public function films()
    {
        return $this->hasMany(Film::class, 'category_id');
    }
}
