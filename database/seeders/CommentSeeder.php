<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            // Фильм 1
            ['user_id' => 1, 'film_id' => 1, 'text' => 'Amazing movie! Really enjoyed it.'],
            ['user_id' => 3, 'film_id' => 1, 'text' => 'Good story, but pacing was slow.'],

            // Фильм 2
            ['user_id' => 2, 'film_id' => 2, 'text' => 'Loved the cinematography!'],
            ['user_id' => 4, 'film_id' => 2, 'text' => 'The acting was top-notch.'],

            // Фильм 3
            ['user_id' => 3, 'film_id' => 3, 'text' => 'Could have been shorter, but overall enjoyable.'],
            ['user_id' => 1, 'film_id' => 3, 'text' => 'Great soundtrack and visuals.'],

            // Фильм 4
            ['user_id' => 4, 'film_id' => 4, 'text' => 'Not my favorite, but worth watching.'],
            ['user_id' => 2, 'film_id' => 4, 'text' => 'Interesting plot twists.'],

            // Фильм 5
            ['user_id' => 1, 'film_id' => 5, 'text' => 'Absolutely loved it!'],
            ['user_id' => 4, 'film_id' => 5, 'text' => 'A bit predictable, but enjoyable.'],

            // Фильм 6
            ['user_id' => 2, 'film_id' => 6, 'text' => 'Stunning visuals and story.'],
            ['user_id' => 3, 'film_id' => 6, 'text' => 'One of the best movies I have seen.'],

            // Фильм 7
            ['user_id' => 1, 'film_id' => 7, 'text' => 'Great acting by the cast.'],
            ['user_id' => 4, 'film_id' => 7, 'text' => 'Loved every scene.'],

            // Фильм 8
            ['user_id' => 3, 'film_id' => 8, 'text' => 'A masterpiece in every sense.'],
            ['user_id' => 2, 'film_id' => 8, 'text' => 'Will watch it again!'],

            // Фильм 9
            ['user_id' => 4, 'film_id' => 9, 'text' => 'Emotional and gripping story.'],
            ['user_id' => 1, 'film_id' => 9, 'text' => 'Fantastic direction and screenplay.'],

            // Фильм 10
            ['user_id' => 2, 'film_id' => 10, 'text' => 'Highly recommend to everyone.'],
            ['user_id' => 3, 'film_id' => 10, 'text' => 'Superb soundtrack and visuals.'],

            // Фильм 11
            ['user_id' => 1, 'film_id' => 11, 'text' => 'Very entertaining and well-made.'],
            ['user_id' => 4, 'film_id' => 11, 'text' => 'Plot twists kept me hooked.'],

            // Фильм 12
            ['user_id' => 3, 'film_id' => 12, 'text' => 'Amazing experience from start to finish.'],
            ['user_id' => 2, 'film_id' => 12, 'text' => 'Cinematography is breathtaking.'],
        ];

        foreach ($comments as $comment) {
            DB::table('comments')->insert([
                'user_id' => $comment['user_id'],
                'film_id' => $comment['film_id'],
                'text' => $comment['text'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
