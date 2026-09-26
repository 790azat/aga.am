<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Action'],
            ['name' => 'Drama'],
            ['name' => 'Crime'],
            ['name' => 'Comedy'],
            ['name' => 'Horror'],
            ['name' => 'Sci-Fi'],
            ['name' => 'Romance'],
            ['name' => 'Thriller'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
