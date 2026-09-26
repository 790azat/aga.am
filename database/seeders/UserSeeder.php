<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Пароль админов берётся из .env (SEED_ADMIN_PASSWORD), в репозитории его нет.
        // Если переменная не задана, генерируется случайный пароль.
        $adminPassword = env('SEED_ADMIN_PASSWORD') ?: Str::random(32);

        User::create([
            'name' => 'Azat',
            'email' => 'vip.azatazat@gmail.com',
            'password' => Hash::make($adminPassword),
            'avatar' => 'avatars/azat.png',
            'type' => 'admin',
        ]);

        User::create([
            'name' => 'Andranik',
            'email' => 'andranikabrahamianwork@gmail.com',
            'password' => Hash::make($adminPassword),
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
