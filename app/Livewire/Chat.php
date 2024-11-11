<?php

namespace App\Livewire;

use App\Adapters\OpenAiAdapter;
use App\Models\Message;
use App\Services\ChatService;
use App\Services\FakeOpenAIService;
use App\Services\OpenAIService;
use Livewire\Component;

class Chat extends Component
{
    // поле для отправки сообщения
    public $message;
    // поле чата
    public $response;
    // список чатов
    public $chats;
    // для выделения текущего чата в списке
    public $currentChatId;

    public function mount()
    {
        // получаем текущий чат или создаем новый
        // логика авто создания нового чата находится в этом сервисе
        $chatService = new ChatService();

        // назначаем текущий чат, для выделения в списке
        $this->currentChatId = $chatService->getChat()->id;
        // список последних чатов
        // переменная $this->chats транслируется в шаблон
        $this->chats = $chatService->getLastChats();
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string|max:255|min:2',
        ]);

        // получаем ответ от ИИ
        $openAIService = new OpenAIService();
        $openAiResponse = $openAIService->getChatGPTResponse($this->message);

        // пришел ли объект от чата в ответ
        if ($openAiResponse) {
            $response = new OpenAiAdapter($openAiResponse);
            $this->response[] = $response->getMessage();
        }
        else {
            $this->response[] = 'Ошибка сервера.';
            logger($openAIService->getError());
            return false;
        }

        // списываем с баланса токены вопроса и ответа

        // сохраняем сообщение в базе
        $message = Message::create([
            'chat_id' => session('chat_id', null),
            'content' => $this->message,
            'tokens' => $response->getInputTokens(),
        ]);

        // сохраняем ответ чата
        Message::create([
            'chat_id' => session('chat_id', null),
            'content' => $response->getMessage(),
            'tokens' => $response->getOutputTokens(),
            'response_for' => $message->id,
        ]);

        // Очищаем поле после отправки
        $this->message = '';
    }

    public function createChat()
    {
        $chatService = new ChatService();
        // добавляем новый чат
        $chatService->add();
        // назначаем текущий чат, для выделения в списке
        $this->currentChatId = $chatService->getChat()->id;
        // Обновляем список чатов
        $this->chats = $chatService->getLastChats();
        // очищаем список ответов чата
        $this->response = [];
    }

    public function renameChat()
    {
        $chatService = new ChatService();

        $chatService->renameChat();
    }

    public function render()
    {
        return view('livewire.chat');
    }
}


