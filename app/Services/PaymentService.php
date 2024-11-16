<?php


namespace App\Services;


class PaymentService
{
    const PRICE_INPUT_TOKENS = 150; // за 1М исходящих токенов
    const PRICE_OUTPUT_TOKENS = 600; // 1М входящих
    const PRICE_PER = 1000000; // цена за 1М

    private $wasSpent;

    public function costInput($tokens)
    {
        return (static::PRICE_INPUT_TOKENS / static::PRICE_PER) * $tokens;
    }

    public function costOutput($tokens)
    {
        return (static::PRICE_OUTPUT_TOKENS / static::PRICE_PER) * $tokens;
    }

    /**
     * Списывает со счета баланс
     * @param array $tokens с ключами input и/или output
     */
    public function spend(array $tokens)
    {
        $credits = auth()->user()->credits;

        if (isset($tokens['input'])) {
            $cost = $this->costInput($tokens['input']);
            $credits->amount -= $cost;
            $this->wasSpent += $cost;
        }
        if (isset($tokens['output'])) {
            $cost = $this->costOutput($tokens['output']);
            $credits->amount -= $cost;
            $this->wasSpent += $cost;
        }

        $credits->save();
    }

    public function wasSpent()
    {
        return $this->wasSpent;
    }
}
