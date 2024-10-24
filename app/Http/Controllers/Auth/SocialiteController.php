<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            // Проверка, существует ли пользователь
            $user = User::where('facebook_id', $facebookUser->id)->first();

            if ($user) {
                // Пользователь уже существует, авторизуем его
                Auth::login($user);
            } else {
                // Если пользователя нет, создаем нового
                $user = User::create([
                                         'name' => $facebookUser->name,
                                         'email' => $facebookUser->email,
                                         'facebook_id' => $facebookUser->id,
                                         'password' => Hash::make(Str::random(24)), // Случайный пароль
                                     ]);

                Auth::login($user);
            }

            // Перенаправляем пользователя на домашнюю страницу после входа
            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['msg' => 'Ошибка входа через Facebook']);
        }
    }
}
