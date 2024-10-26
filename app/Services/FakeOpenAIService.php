<?php

namespace App\Services;

class FakeOpenAIService
{
    public function getChatGPTResponse(string $message): string
    {
        return "Это тестовый ответ для сообщения: " . $message;
    }
}
