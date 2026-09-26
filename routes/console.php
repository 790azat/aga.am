<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Сброс пароля пользователя. Новый пароль берётся из переменной NEW_PASSWORD, чтобы он не попадал
// в историю команд и в логи GitHub Actions (там он приходит из секрета).
Artisan::command('user:password {email}', function (string $email) {
    $password = (string) getenv('NEW_PASSWORD');

    if (strlen($password) < 8) {
        $this->error('Задайте NEW_PASSWORD (не короче 8 символов).');

        return 1;
    }

    $user = User::where('email', $email)->first();

    if (! $user) {
        $this->error("Пользователь {$email} не найден.");

        return 1;
    }

    $user->forceFill(['password' => Hash::make($password)])->save();
    $this->info("Пароль для {$email} обновлён.");

    return 0;
})->purpose('Задать новый пароль пользователю');
