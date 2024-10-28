<?php

namespace App\Livewire;

use App\Services\FakeOpenAIService;
use Livewire\Component;

class Chat extends Component
{
    public $message;
    public $response;
    public $chats;

    public function mount()
    {
        $chatId = session('chat_id', null);
        // ели в сессии есть chat_id
        if ($chatId) {
            // проверяем его наличие в базе
            $chat = \App\Models\Chat::find($chatId);
            // и принадлежность к текущему пользователю
            if (!$chat || $chat->user->id !== auth()->user()->id) {
                $chatId = null;
                $chat = null;
                session()->forget('chat_id');
            }
        }

        if (!$chatId) {
            // test
            // todo определять имя чата
            $chat = new \App\Models\Chat();
            $chat->name = 'Test name 3';
            $chat->user_id = auth()->user()->id;
            $chat->save();
            // запоминаем в сессии
            session(['chat_id' => $chat->id]);
        }

        $this->chats[] = $chat;
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string|max:255|min:3',
        ]);

        // получаем ответ от ИИ
        $openAIService = new FakeOpenAIService();
        $this->response[] = $openAIService->getChatGPTResponse($this->message);

        // сохраняем в базе

        // Очищаем поле после отправки
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chat');
    }
}


