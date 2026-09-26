<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    public function run(): void
    {
        Film::create([
            'name' => 'Blade Runner 2049',
            'category_id' => 6,
            'genres' => [6, 5, 3],
            'year' => 2017,
            'director' => 'Denis Villeneuve',
            'producer' => 'Ridley Scott',
            'poster' => 'posters/blade_runner_2049.png',
            'background' => 'backgrounds/blade_runner_bg.jpg',
            'logo' => null,
            'video' => 'videos/trailer.mp4',
            'description' => 'Blade Runner 2049 (2017) is a visually spectacular neo-noir sci-fi masterpiece...',
            'rating' => 8.1,
        ]);

        Film::create([
            'name' => 'Inception',
            'category_id' => 6,
            'genres' => [6, 4, 1, 2],
            'year' => 2010,
            'director' => 'Christopher Nolan',
            'producer' => 'Emma Thomas',
            'poster' => 'posters/inception.png',
            'background' => 'backgrounds/inception_bg.jpg',
            'logo' => null,
            'video' => 'videos/trailer.mp4',
            'description' => 'Inception (2010) is a mind-bending sci-fi thriller...',
            'rating' => 8.8,
        ]);

        Film::create([
            'name' => 'The Dark Knight',
            'category_id' => 1,
            'genres' => [1, 3, 6],
            'year' => 2008,
            'director' => 'Christopher Nolan',
            'producer' => 'Emma Thomas',
            'poster' => 'posters/dark_knight.png',
            'background' => 'backgrounds/dark_knight_bg.jpg',
            'logo' => null,
            'video' => 'videos/trailer.mp4',
            'description' => 'The Dark Knight (2008) is a acclaimed superhero crime-thriller...',
            'rating' => 9.0,
        ]);

        Film::create([
            'name' => 'Parasite',
            'category_id' => 2,
            'genres' => [2, 4, 5],
            'year' => 2019,
            'director' => 'Bong Joon-ho',
            'producer' => 'Kwak Sin-ae',
            'poster' => 'posters/parasite.png',
            'background' => 'backgrounds/parasite_bg.jpg',
            'logo' => null,
            'video' => 'videos/trailer.mp4',
            'description' => 'Parasite (2019), directed by Bong Joon-ho, is a darkly comedic social thriller...',
            'rating' => 8.6,
        ]);

        Film::create([
            'name' => 'The Godfather',
            'category_id' => 3,
            'genres' => [3, 2, 6],
            'year' => 1972,
            'director' => 'Francis Ford Coppola',
            'producer' => 'Albert S. Ruddy',
            'poster' => 'posters/godfather.png',
            'background' => 'backgrounds/godfather_bg.jpg',
            'logo' => null,
            'video' => 'videos/trailer.mp4',
            'description' => 'The Godfather (1972), directed by Francis Ford Coppola, is a premier American crime film...',
            'rating' => 9.2,
        ]);

        // Дополнительные фильмы
        Film::create([
            'name' => 'Interstellar',
            'category_id' => 6,
            'genres' => [6, 4, 1],
            'year' => 2014,
            'director' => 'Christopher Nolan',
            'producer' => 'Emma Thomas',
            'poster' => 'posters/interstellar.png',
            'background' => 'backgrounds/interstellar_bg.jpg',
            'logo' => null,
            'video' => 'videos/trailer.mp4',
            'description' => 'Interstellar (2014) explores humanity’s search for a new home among the stars...',
            'rating' => 8.6,
        ]);

        Film::create([
            'name' => 'Joker',
            'category_id' => 1,
            'genres' => [1, 5, 6],
            'year' => 2019,
            'director' => 'Todd Phillips',
            'producer' => 'Bradley Cooper',
            'poster' => 'posters/joker.png',
            'background' => 'backgrounds/joker_bg.jpg',
            'logo' => null,
            'video' => 'videos/trailer.mp4',
            'description' => 'Joker (2019) is a dark character study of the infamous DC villain...',
            'rating' => 8.5,
        ]);

        Film::create([
            'name' => 'Avengers: Endgame',
            'category_id' => 1,
            'genres' => [1, 4, 6],
            'year' => 2019,
            'director' => 'Anthony Russo, Joe Russo',
            'producer' => 'Kevin Feige',
            'poster' => 'posters/avengers_endgame.png',
            'background' => 'backgrounds/avengers_bg.jpg',
            'logo' => null,
            'video' => 'videos/trailer.mp4',
            'description' => 'Avengers: Endgame (2019) is the epic conclusion to the Marvel Infinity Saga...',
            'rating' => 8.4,
        ]);

        Film::create([
            'name' => 'Fight Club',
            'category_id' => 2,
            'genres' => [2, 3, 6],
            'year' => 1999,
            'director' => 'David Fincher',
            'producer' => 'Art Linson',
            'poster' => 'posters/fight_club.png',
            'background' => 'backgrounds/fight_club_bg.jpg',
            'logo' => null,
            'video' => 'videos/trailer.mp4',
            'description' => 'Fight Club (1999) follows an insomniac office worker who forms an underground fight club...',
            'rating' => 8.8,
        ]);

        Film::create([
            'name' => 'Pulp Fiction',
            'category_id' => 3,
            'genres' => [3, 2, 5],
            'year' => 1994,
            'director' => 'Quentin Tarantino',
            'producer' => 'Lawrence Bender',
            'poster' => 'posters/pulp_fiction.png',
            'background' => 'backgrounds/pulp_fiction_bg.jpg',
            'logo' => null,
            'video' => 'videos/trailer.mp4',
            'description' => 'Pulp Fiction (1994) intertwines multiple stories of crime in Los Angeles...',
            'rating' => 8.9,
        ]);

        Film::create([
            'name' => 'Forrest Gump',
            'category_id' => 2,
            'genres' => [2, 5, 6],
            'year' => 1994,
            'director' => 'Robert Zemeckis',
            'producer' => 'Wendy Finerman',
            'poster' => 'posters/forrest_gump.png',
            'background' => 'backgrounds/forrest_gump_bg.jpg',
            'logo' => null,
            'video' => 'videos/trailer.mp4',
            'description' => 'Forrest Gump (1994) follows the life journey of a simple man who witnesses and influences history...',
            'rating' => 8.8,
        ]);

        Film::create([
            'name' => 'The Matrix',
            'category_id' => 6,
            'genres' => [6, 1, 4],
            'year' => 1999,
            'director' => 'Lana Wachowski, Lilly Wachowski',
            'producer' => 'Joel Silver',
            'poster' => 'posters/matrix.png',
            'background' => 'backgrounds/matrix_bg.jpg',
            'logo' => null,
            'video' => 'videos/trailer.mp4',
            'description' => 'The Matrix (1999) is a revolutionary sci-fi action film about a simulated reality...',
            'rating' => 8.7,
        ]);
    }
}
