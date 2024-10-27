<?php

namespace App\Livewire;

use App\Services\FakeOpenAIService;
use Livewire\Component;

class Chat extends Component
{
    public $message;
    public $response;

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string|max:255',
        ]);

        $openAIService = new FakeOpenAIService();
        $this->response[] = $openAIService->getChatGPTResponse($this->message);

        // Очищаем поле после отправки
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chat');
    }
}


