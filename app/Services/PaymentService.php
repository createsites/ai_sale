<?php


namespace App\Services;


class PaymentService
{
    const PRICE_INPUT_TOKENS = 150; // за 1М исходящих токенов
    const PRICE_OUTPUT_TOKENS = 600; // 1М входящих
    const PRICE_PER = 1000000; // цена за 1М

    public static function costInput($tokens)
    {
        return (static::PRICE_INPUT_TOKENS / static::PRICE_PER) * $tokens;
    }

    public static function costOutput($tokens)
    {
        return (static::PRICE_OUTPUT_TOKENS / static::PRICE_PER) * $tokens;
    }

    /**
     * Списывает со счета баланс
     * @param array $tokens с ключами input и/или output
     */
    public static function spend(array $tokens)
    {
        $credits = auth()->user()->credits;

        if (isset($tokens['input'])) {
            $credits->amount -= static::costInput($tokens['input']);
        }
        if (isset($tokens['output'])) {
            $credits->amount -= static::costOutput($tokens['output']);
        }

        $credits->save();
    }
}
