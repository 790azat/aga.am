<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\PosterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;


Route::get('/reset', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');
    return redirect('/');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});


Auth::routes();

Route::get('/', PosterController::class . '@index');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/film/{film_id}', [FilmController::class, 'index']);
Route::get('/actor/{id}', ActorController::class . '@index')->name('actor.index');



// FILM (только авторизованный)
Route::middleware('admin')->group(function () {

    Route::post('/film/upload', [FilmController::class, 'upload'])->name('film.upload');
    Route::put('/film/{id}', [FilmController::class, 'update'])->name('film.update');
    Route::delete('/film/{id}', [FilmController::class, 'destroy'])->name('film.destroy');

});


// ADMIN PANEL (доступ админ/модератор — зависит от твоего user.type)
Route::prefix('admin')
    ->middleware('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/moderators', [AdminController::class, 'moderators'])->name('admin.moderators');
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


// ONLY ADMIN (редактирование модераторов)
Route::prefix('admin')
    ->middleware('admin')
    ->group(function () {

        Route::post('/make-moderator', [ModeratorController::class, 'makeModerator'])->name('admin.users.makeModerator');
        Route::post('/remove-moderator', [ModeratorController::class, 'removeModerator'])->name('admin.users.removeModerator');
        Route::post('/change-password', [ModeratorController::class, 'changePassword'])->name('admin.users.changePassword');

    });



Route::get('/actors-download', function () {

    $actors = [
        // Blade Runner 2049
        'Ryan Gosling',
        'Harrison Ford',
        'Ana de Armas',
        'Jared Leto',

        // Inception
        'Leonardo DiCaprio',
        'Ken Watanabe',
        'Joseph Gordon-Levitt',
        'Ellen Page',
        'Tom Hardy',
        'Michael Caine',
        'Cillian Murphy',

        // The Dark Knight
        'Christian Bale',
        'Heath Ledger',
        'Gary Oldman',
        'Morgan Freeman',
        'Aaron Eckhart',
        'Michael Caine DK',

        // Parasite
        'Song Kang-ho',
        'Lee Sun-kyun',
        'Cho Yeo-jeong',
        'Park So-dam',
        'Choi Woo-shik',

        // The Godfather
        'Marlon Brando',
        'Al Pacino',
        'James Caan',
        'Robert Duvall',

        // Interstellar
        'Matthew McConaughey',
        'Anne Hathaway',
        'Jessica Chastain',
        'Michael Caine IS',

        // Joker
        'Joaquin Phoenix',
        'Robert De Niro',

        // Avengers: Endgame
        'Robert Downey Jr.',
        'Chris Evans',
        'Scarlett Johansson',
        'Chris Hemsworth',

        // Fight Club
        'Brad Pitt',
        'Edward Norton',
        'Helena Bonham Carter',

        // Pulp Fiction
        'John Travolta',
        'Uma Thurman',
        'Samuel L. Jackson',

        // Forrest Gump
        'Tom Hanks',
        'Robin Wright',
        'Gary Sinise',

        // The Matrix
        'Keanu Reeves',
        'Laurence Fishburne',
        'Carrie-Anne Moss',
        'Hugo Weaving',
    ];


    $dir = public_path('actors/');
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $apiKey = '6ba14aae-0432-43c9-87a0-d53b8eb2b288';

    foreach ($actors as $actorName) {

        // 1️⃣ Получаем kinopoiskId
        $searchUrl = 'https://kinopoiskapiunofficial.tech/api/v1/persons?name=' . urlencode($actorName) . '&page=1';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $searchUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'X-Api-Key: ' . $apiKey
        ]);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error (search) for ' . $actorName . ': ' . curl_error($ch) . '<br>';
            curl_close($ch);
            continue;
        }
        curl_close($ch);

        $data = json_decode($result, true);
        if (!isset($data['items'][0]['kinopoiskId'])) {
            echo 'No kinopoiskId for ' . $actorName . '<br>';
            continue;
        }

        $kinopoiskId = $data['items'][0]['kinopoiskId'];

        // 2️⃣ Получаем posterUrl через staff/{id}
        $staffUrl = 'https://kinopoiskapiunofficial.tech/api/v1/staff/' . $kinopoiskId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $staffUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'X-Api-Key: ' . $apiKey
        ]);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error (staff) for ' . $actorName . ': ' . curl_error($ch) . '<br>';
            curl_close($ch);
            continue;
        }
        curl_close($ch);

        $staffData = json_decode($result, true);
        if (!isset($staffData['posterUrl'])) {
            echo 'No posterUrl for ' . $actorName . '<br>';
            continue;
        }

        $posterUrl = $staffData['posterUrl'];
        $extension = pathinfo(parse_url($posterUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
        $fileName = Str::slug($actorName) . '.' . $extension;

        // Сохраняем изображение
        file_put_contents($dir . $fileName, file_get_contents($posterUrl));
        echo "Downloaded: {$actorName}<br>";
    }

    echo 'All done!';
});








