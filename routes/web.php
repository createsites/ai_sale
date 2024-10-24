<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\SocialiteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// FB

Route::get('auth/facebook', [SocialiteController::class, 'redirectToFacebook'])->name('facebook.login');
Route::get('auth/facebook/callback', [SocialiteController::class, 'handleFacebookCallback']);

// VK

Route::get('auth/vk', function () {
    return Socialite::driver('vkontakte')->redirect();
})->name('vk.login');;

Route::get('auth/vk/callback', function () {
    $user = Socialite::driver('vkontakte')->user();
    // Логика для регистрации или аутентификации пользователя
    // Например, вы можете проверить, существует ли пользователь в базе данных,
    // и если нет, создать нового пользователя

    $authUser = User::firstOrCreate([
        'vk_id' => $user->id,
    ], [
        'name' => $user->name,
        'email' => $user->email, // Убедитесь, что вы получили email от VK
        // Другие поля, которые вам нужны
    ]);

    Auth::login($authUser, true);

    return redirect()->to('/'); // Перенаправление после входа
});

require __DIR__.'/auth.php';
