<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    // драйвер задается в дочерних классах
    // например, google, vk, и т.д.
    const DRIVER = 'unknown';
    // в таблице пользователей поле для сохранения id соцсети
    // будет называться например google_id
    const NETWORK_ID_FIELD = 'unknown';

    public function redirect()
    {
        return Socialite::driver(static::DRIVER)->redirect();
    }

    public function callback()
    {
        try {
            // массив с данными о пользователе после oauth
            $oauthUser = Socialite::driver(static::DRIVER)->user();
        } catch (\Exception $e) {
            // Обработка исключений, если запрос к oauth завершился ошибкой
            return redirect(route('login'))->with('error', 'Ошибка при авторизации через ' . static::DRIVER);
        }

        // ищем в базе e-mail авторизовавшегося юзера
        $user = User::where('email', $oauthUser->getEmail())->first();
        // если находим
        if ($user) {
            // привязываем аккаунт социальной сети
            $user->{static::NETWORK_ID_FIELD} = $oauthUser->getId(); // сохраняем ID соцсети
            $user->save();
        }
        // иначе создаем новый акк
        // отмечаем e-mail как верифицированный
        else {
            $user = new User();
            $user->name = $oauthUser->getName();
            $user->email = $oauthUser->getEmail();
            $user->{static::NETWORK_ID_FIELD} = $oauthUser->getId();
            $user->password = bcrypt(Str::random(12));  // Можно сгенерировать пароль
//            $user = User::create([
//               'name'              => $oauthUser->getName(),
//               'email'             => $oauthUser->getEmail(),
//               static::NETWORK_ID_FIELD         => $oauthUser->getId(),  // Сохраняем ID Google
//                // TODO отправлять сгенерированный пароль на почту
//               'password'          => bcrypt(Str::random(12)),  // Можно сгенерировать пароль
//               'email_verified_at' => now(),  // Отмечаем e-mail как верифицированный
//           ]);

            $user->forceFill([
                'email_verified_at' => now(),
            ]);
            $user->save();
        }

        // Авторизуем пользователя
        Auth::login($user);
        // Перенаправляем пользователя в панель управления
        return redirect(route('dashboard'));
    }
}

