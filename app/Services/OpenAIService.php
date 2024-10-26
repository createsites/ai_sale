<?php

namespace App\Services;

use OpenAI;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client(config('services.openai.key'));
    }

    public function getChatGPTResponse(string $message): string
    {
        try {
            $response = $this->client->chat()->create(
                [
                    'model' => 'gpt-3.5-turbo', // или "gpt-4" при наличии доступа
                    'messages' => [
                        ['role' => 'user', 'content' => $message],
                    ],
                ]
            );
        } catch (OpenAI\Exceptions\ErrorException $e) {
            // скорее всего кончились деньги
            return 'Превышен лимит запросов к API. Пожалуйста, попробуйте позже или обратитесь в поддержку.';
        }

        return $response['choices'][0]['message']['content'] ?? 'Нет ответа';
    }
}
