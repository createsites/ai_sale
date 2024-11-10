<?php


namespace App\Adapters;


class OpenAiAdapter
{
    private $openAiResponse;

    public function __construct(\OpenAI\Responses\Chat\CreateResponse $openAiResponse)
    {
        $this->openAiResponse = $openAiResponse;
    }

    public function getMessage()
    {
        return $this->openAiResponse['choices'][0]['message']['content'] ?? 'Нет ответа';
    }

    public function getInputTokens()
    {
        return $this->openAiResponse['usage']['prompt_tokens'];
    }
}
