<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PosterController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/reset', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');
    return redirect('/');
});
Route::get('/', PosterController::class . '@index');

Route::get('checkout',  function () {
    return view('payment.checkout');
})->name('checkout');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth', 'verified', 'user.type')
    ->name('home');

Route::get('/admin/dashboard', AdminController::class . '@index')->name('admin.dashboard');
Route::get('/admin/moderators', AdminController::class . '@moderators')->name('admin.moderators');
Route::get('/admin/videos', AdminController::class . '@videos')->name('admin.videos');
Route::get('/admin/users', AdminController::class . '@users')->name('admin.users');
Route::get('/admin/cashier', AdminController::class . '@cashier')->name('admin.cashier');
Route::get('/admin/history', AdminController::class . '@history')->name('admin.history');
Route::get('/admin/settings', AdminController::class . '@settings')->name('admin.settings');










