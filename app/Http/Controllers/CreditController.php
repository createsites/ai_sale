<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Credit;

class CreditController extends Controller
{
    public function showTopUpForm()
    {
        return view('credits.topup');
    }

    public function topUpCredits(Request $request)
    {
        $request->validate([
               'amount' => 'required|integer|min:1',
           ]);

        // Логика обработки платежа
        $user = auth()->user();
        $credit = $user->credits;
        // если нет записи в базе о кредитах
        if (!$credit) {
            // создаем
            Credit::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
           ]);
        }
        // иначе увеличиваем имеющуюся сумму
        else {
            $credit->increment('amount', $request->amount);
        }

        return redirect(route('dashboard'))->with('success', 'Ваши кредиты успешно пополнены!');
    }
}

