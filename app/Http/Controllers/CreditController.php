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
        $credit = Credit::firstOrCreate(['user_id' => $user->id]);
        $credit->increment('amount', $request->amount);

        return redirect(route('dashboard'))->with('success', 'Ваши кредиты успешно пополнены!');
    }
}

