<?php

namespace App\Services;

use OpenAI;

class OpenAIService
{
    const USER_ROLE = 'user';
    const ASSISTANT_ROLE = 'assistant';

    private $client;
    private $error;

    public function __construct()
    {
        $this->client = OpenAI::client(config('services.openai.key'));
    }

    /**
     * Делаем запрос к чату по апи
     * @param array $messages массив с вопросами
     * @return false | \OpenAI\Responses\Chat\CreateResponse
     * Если произошла ошибка - возвращаем строку с ошибкой
     * Успешно - структуру ответа от чата
     * В структуре могут содержаться несколько вариантов ответов, пока по умолчанию выбираем первый $response['choices']
     * Есть инфа о кол-ве входящих и исходящих токенов
     * исходящие токены $response['usage']['prompt_tokens']
     * входящие токены $response['usage']['completion_tokens']
     * инфа о модели $response['model']
     * здесь сказано что ответ корректно завершился $response['choices'][0][finishReason] = 'stop', возможно это в будущем надо обрабатывать
     * время исполнения запроса $response['meta']['processingMs']
     */
    public function getChatGPTResponse(array $messages)
    {
        try {
            $response = $this->client->chat()->create(
                [
                    'model' => 'gpt-3.5-turbo', // или "gpt-4" при наличии доступа
                    // массив с сообщениями вида
                    // [['role' => 'user', 'content' => $message]]
                    // role может быть user или assistant
                    // передается массивом весь контекст беседы
                    'messages' => $messages,
                ]
            );
        } catch (OpenAI\Exceptions\ErrorException $e) {
            // скорее всего кончились деньги
            if (false !== strpos($e->getMessage(), 'You exceeded your current quota')) {
                $this->error = 'Превышен лимит запросов к API. Пожалуйста, попробуйте позже или обратитесь в поддержку.';
            }
            // неизвестная ошибка
            else {
                $this->error = 'Сервис временно недоступен. ' . $e->getMessage();
            }
            return false;
        }

        return $response;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Подготовка массива сообщений контекста
     * @param $messages array \App\Models\Message
     * @return array
     */
    public function makeContextFromMessages($messages)
    {
        $context = [];
        foreach ($messages as $message) {
            $context[] = [
                'role' => $message->response_for ? static::ASSISTANT_ROLE : static::USER_ROLE,
                'content' => $message->content
            ];
        }
        return $context;
    }
}
