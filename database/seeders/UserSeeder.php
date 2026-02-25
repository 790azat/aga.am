<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Azat',
            'email' => 'vip.azatazat@gmail.com',
            'password' => Hash::make('790FerariFerari790.'),
            'avatar' => 'avatars/azat.png',
            'type' => 'admin',
        ]);

        User::create([
            'name' => 'Andranik',
            'email' => 'andranikabrahamianwork@gmail.com',
            'password' => Hash::make('password'),
            'avatar' => 'avatars/andranik.jpg',
            'type' => 'admin',
        ]);



        User::create([
            'name' => 'Davo',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'type' => 'user',
        ]);

        User::create([
            'name' => 'Gugo',
            'email' => 'gugo@example.com',
            'password' => Hash::make('password'),
            'type' => 'user',
        ]);
    }
}
