<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ActorSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $actors = [
            // Blade Runner 2049
            ['name' => 'Ryan Gosling', 'avatar' => 'actors/ryan-gosling.jpg', 'bio' => 'Officer K in Blade Runner 2049.'],
            ['name' => 'Harrison Ford', 'avatar' => 'actors/harrison-ford.jpg', 'bio' => 'Rick Deckard in Blade Runner 2049.'],
            ['name' => 'Ana de Armas', 'avatar' => 'actors/ana-de-armas.jpg', 'bio' => 'Joi in Blade Runner 2049.'],
            ['name' => 'Jared Leto', 'avatar' => 'actors/jared-leto.jpg', 'bio' => 'Niander Wallace.'],

            // Inception
            ['name' => 'Leonardo DiCaprio', 'avatar' => 'actors/leonardo-dicaprio.jpg', 'bio' => 'Dom Cobb in Inception.'],
            ['name' => 'Ken Watanabe', 'avatar' => 'actors/ken-watanabe.jpg', 'bio' => 'Saito in Inception.'],
            ['name' => 'Joseph Gordon-Levitt', 'avatar' => 'actors/joseph-gordon-levitt.jpg', 'bio' => 'Arthur in Inception.'],
            ['name' => 'Ellen Page', 'avatar' => 'actors/ellen-page.jpg', 'bio' => 'Ariadne in Inception.'],
            ['name' => 'Tom Hardy', 'avatar' => 'actors/tom-hardy.jpg', 'bio' => 'Eames in Inception.'],

            // Michael Caine будет один на три фильма
            ['name' => 'Michael Caine', 'avatar' => 'actors/michael-caine.jpg', 'bio' => 'Appears in Inception, Interstellar and The Dark Knight.'],

            ['name' => 'Cillian Murphy', 'avatar' => 'actors/cillian-murphy.jpg', 'bio' => 'Robert Fischer in Inception.'],

            // The Dark Knight
            ['name' => 'Christian Bale', 'avatar' => 'actors/christian-bale.jpg', 'bio' => 'Batman in The Dark Knight.'],
            ['name' => 'Heath Ledger', 'avatar' => 'actors/heath-ledger.jpg', 'bio' => 'Joker in The Dark Knight.'],
            ['name' => 'Gary Oldman', 'avatar' => 'actors/gary-oldman.jpg', 'bio' => 'Commissioner Gordon.'],
            ['name' => 'Morgan Freeman', 'avatar' => 'actors/morgan-freeman.jpg', 'bio' => 'Lucius Fox.'],
            ['name' => 'Aaron Eckhart', 'avatar' => 'actors/aaron-eckhart.jpg', 'bio' => 'Harvey Dent / Two-Face.'],

            // Parasite
            ['name' => 'Song Kang-ho', 'avatar' => 'actors/song-kang-ho.jpg', 'bio' => 'Ki-taek in Parasite.'],
            ['name' => 'Lee Sun-kyun', 'avatar' => 'actors/lee-sun-kyun.jpg', 'bio' => 'Park Dong-ik in Parasite.'],
            ['name' => 'Cho Yeo-jeong', 'avatar' => 'actors/cho-yeo-jeong.jpg', 'bio' => 'Yeon-kyo in Parasite.'],
            ['name' => 'Park So-dam', 'avatar' => 'actors/park-so-dam.jpg', 'bio' => 'Ki-jung in Parasite.'],
            ['name' => 'Choi Woo-shik', 'avatar' => 'actors/choi-woo-shik.jpg', 'bio' => 'Ki-woo in Parasite.'],

            // The Godfather
            ['name' => 'Marlon Brando', 'avatar' => 'actors/marlon-brando.jpg', 'bio' => 'Don Vito Corleone in The Godfather.'],
            ['name' => 'Al Pacino', 'avatar' => 'actors/al-pacino.jpg', 'bio' => 'Michael Corleone in The Godfather.'],
            ['name' => 'James Caan', 'avatar' => 'actors/james-caan.jpg', 'bio' => 'Sonny Corleone in The Godfather.'],
            ['name' => 'Robert Duvall', 'avatar' => 'actors/robert-duvall.jpg', 'bio' => 'Tom Hagen in The Godfather.'],

            // Interstellar
            ['name' => 'Matthew McConaughey', 'avatar' => 'actors/matthew-mcconaughey.jpg', 'bio' => 'Cooper in Interstellar.'],
            ['name' => 'Anne Hathaway', 'avatar' => 'actors/anne-hathaway.jpg', 'bio' => 'Brand in Interstellar.'],
            ['name' => 'Jessica Chastain', 'avatar' => 'actors/jessica-chastain.jpg', 'bio' => 'Murph in Interstellar.'],

            // Joker
            ['name' => 'Joaquin Phoenix', 'avatar' => 'actors/joaquin-phoenix.jpg', 'bio' => 'Arthur Fleck / Joker.'],
            ['name' => 'Robert De Niro', 'avatar' => 'actors/robert-de-niro.jpg', 'bio' => 'Murray Franklin in Joker.'],

            // Avengers: Endgame
            ['name' => 'Robert Downey Jr.', 'avatar' => 'actors/robert-downey-jr.jpg', 'bio' => 'Iron Man in Avengers: Endgame.'],
            ['name' => 'Chris Evans', 'avatar' => 'actors/chris-evans.jpg', 'bio' => 'Captain America in Avengers: Endgame.'],
            ['name' => 'Scarlett Johansson', 'avatar' => 'actors/scarlett-johansson.jpg', 'bio' => 'Black Widow in Avengers: Endgame.'],
            ['name' => 'Chris Hemsworth', 'avatar' => 'actors/chris-hemsworth.jpg', 'bio' => 'Thor in Avengers: Endgame.'],

            // Fight Club
            ['name' => 'Brad Pitt', 'avatar' => 'actors/brad-pitt.jpg', 'bio' => 'Tyler Durden in Fight Club.'],
            ['name' => 'Edward Norton', 'avatar' => 'actors/edward-norton.jpg', 'bio' => 'The Narrator in Fight Club.'],
            ['name' => 'Helena Bonham Carter', 'avatar' => 'actors/helena-bonham-carter.jpg', 'bio' => 'Marla Singer in Fight Club.'],

            // Pulp Fiction
            ['name' => 'John Travolta', 'avatar' => 'actors/john-travolta.jpg', 'bio' => 'Vincent Vega in Pulp Fiction.'],
            ['name' => 'Uma Thurman', 'avatar' => 'actors/uma-thurman.jpg', 'bio' => 'Mia Wallace in Pulp Fiction.'],
            ['name' => 'Samuel L. Jackson', 'avatar' => 'actors/samuel-l-jackson.jpg', 'bio' => 'Jules Winnfield in Pulp Fiction.'],

            // Forrest Gump
            ['name' => 'Tom Hanks', 'avatar' => 'actors/tom-hanks.jpg', 'bio' => 'Forrest Gump in Forrest Gump.'],
            ['name' => 'Robin Wright', 'avatar' => 'actors/robin-wright.jpg', 'bio' => 'Jenny Curran in Forrest Gump.'],
            ['name' => 'Gary Sinise', 'avatar' => 'actors/gary-sinise.jpg', 'bio' => 'Lieutenant Dan in Forrest Gump.'],

            // The Matrix
            ['name' => 'Keanu Reeves', 'avatar' => 'actors/keanu-reeves.jpg', 'bio' => 'Neo in The Matrix.'],
            ['name' => 'Laurence Fishburne', 'avatar' => 'actors/laurence-fishburne.jpg', 'bio' => 'Morpheus in The Matrix.'],
            ['name' => 'Carrie-Anne Moss', 'avatar' => 'actors/carrie-anne-moss.jpg', 'bio' => 'Trinity in The Matrix.'],
            ['name' => 'Hugo Weaving', 'avatar' => 'actors/hugo-weaving.jpg', 'bio' => 'Agent Smith in The Matrix.'],
        ];

        $actorIds = [];
        foreach ($actors as $actor) {
            $actorIds[] = DB::table('actors')->insertGetId([
                'name' => $actor['name'],
                'avatar' => $actor['avatar'],
                'bio' => $actor['bio'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Связи актёров с фильмами
        $connections = [
            // Blade Runner 2049
            [$actorIds[0], 1], [$actorIds[1], 1], [$actorIds[2], 1], [$actorIds[3], 1],
            // Inception
            [$actorIds[4], 2], [$actorIds[5], 2], [$actorIds[6], 2], [$actorIds[7], 2], [$actorIds[8], 2], [$actorIds[9], 2], [$actorIds[10], 2],
            // The Dark Knight
            [$actorIds[11], 3], [$actorIds[12], 3], [$actorIds[13], 3], [$actorIds[14], 3], [$actorIds[15], 3], [$actorIds[9], 3], // Michael Caine
            // Parasite
            [$actorIds[16], 4], [$actorIds[17], 4], [$actorIds[18], 4], [$actorIds[19], 4], [$actorIds[20], 4],
            // The Godfather
            [$actorIds[21], 5], [$actorIds[22], 5], [$actorIds[23], 5], [$actorIds[24], 5],
            // Interstellar
            [$actorIds[25], 6], [$actorIds[26], 6], [$actorIds[27], 6], [$actorIds[9], 6], // Michael Caine
            // Joker
            [$actorIds[28], 7], [$actorIds[29], 7],
            // Avengers: Endgame
            [$actorIds[30], 8], [$actorIds[31], 8], [$actorIds[32], 8], [$actorIds[33], 8],
            // Fight Club
            [$actorIds[34], 9], [$actorIds[35], 9], [$actorIds[36], 9],
            // Pulp Fiction
            [$actorIds[37], 10], [$actorIds[38], 10], [$actorIds[39], 10],
            // Forrest Gump
            [$actorIds[40], 11], [$actorIds[41], 11], [$actorIds[42], 11],
            // The Matrix
            [$actorIds[43], 12], [$actorIds[44], 12], [$actorIds[45], 12], [$actorIds[46], 12],
        ];

        foreach ($connections as $conn) {
            DB::table('actor_film')->insert([
                'actor_id' => $conn[0],
                'film_id' => $conn[1],
            ]);
        }
    }
}
