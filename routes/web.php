<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\PosterController;
use App\Models\User;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Laravel\Socialite\Facades\Socialite;

Auth::routes();

Route::get('/', PosterController::class.'@index');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/film/{film_id}', [FilmController::class, 'index']);
Route::get('/actor/{id}', ActorController::class.'@index')->name('actor.index');
// Файлы из приватного Vercel Blob. Без сессии и cookies, чтобы CDN мог их кэшировать.
Route::get('/media/{path}', MediaController::class)->where('path', '.*')->name('media')
    ->withoutMiddleware([
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        ShareErrorsFromSession::class,
        PreventRequestForgery::class,
    ]);

// FILM (админ и модератор)
Route::middleware('admin:admin,moderator')->group(function () {

    Route::post('/film/upload', [FilmController::class, 'upload'])->name('film.upload');
    Route::put('/film/{film}', [FilmController::class, 'update'])->name('film.update');
    Route::delete('/film/{film}', [FilmController::class, 'destroy'])->name('film.destroy');

});

// ADMIN PANEL (доступ админ/модератор)
Route::prefix('admin')
    ->middleware('admin:admin,moderator')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/films', [AdminController::class, 'films'])->name('admin.films');

        Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('category.store');
        Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('category.update');
        Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('category.destroy');

        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/cashier', [AdminController::class, 'cashier'])->name('admin.cashier');
        Route::get('/history', [AdminController::class, 'history'])->name('admin.history');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    });

// ONLY ADMIN (управление модераторами)
Route::prefix('admin')
    ->middleware('admin')
    ->group(function () {

        Route::get('/moderators', [AdminController::class, 'moderators'])->name('admin.moderators');

        Route::post('/make-moderator', [ModeratorController::class, 'makeModerator'])->name('admin.users.makeModerator');
        Route::post('/remove-moderator', [ModeratorController::class, 'removeModerator'])->name('admin.users.removeModerator');
        Route::post('/change-password', [ModeratorController::class, 'changePassword'])->name('admin.users.changePassword');

    });

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {

    $googleUser = Socialite::driver('google')->user();

    $avatarUrl = str_replace('s96-c', 's512-c', $googleUser->getAvatar());
    $avatarPath = 'avatars/'.$googleUser->getId().'.png';

    // скачать аватар
    $avatar = Http::get($avatarUrl)->body();

    // сохранить файл
    Storage::disk('public')->put($avatarPath, $avatar);

    $user = User::where('email', $googleUser->email)->first();

    if (! $user) {

        $user = User::create([
            'name' => explode(' ', $googleUser->name)[0],
            'email' => $googleUser->email,
            'google_id' => $googleUser->getId(),
            'avatar' => $avatarPath,
            'password' => Hash::make(Str::random(24)),
        ]);

    } else {

        if (! $user->google_id) {
            $user->google_id = $googleUser->getId();
        }

        // обновить аватар
        $user->avatar = $avatarPath;
        $user->save();
    }

    Auth::login($user);

    return redirect('/home');
});
