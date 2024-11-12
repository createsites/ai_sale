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
        // выводим историю сообщений
        $this->response = $chatService->getChat()->messages;
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string|max:255|min:2',
        ]);

        // получаем ответ от ИИ
        $openAIService = new OpenAIService();
        // ему нужно каждый раз отправлять весь контекст в сообщении
        // поэтому подготавливаем массив из истории
        $context = $openAIService->makeContextFromMessages($this->response);

        // и добавляем отправляемое сообщение $this->message
        $context[] = [
            'role' => OpenAIService::USER_ROLE,
            'content' => $this->message,
        ];

        $openAiResponse = $openAIService->getChatGPTResponse($context);

        // пришел ли объект от чата в ответ
        if ($openAiResponse) {
            $response = new OpenAiAdapter($openAiResponse);
        }
        else {
            // todo выводить ошибку
            logger($openAIService->getError());
            return false;
        }

        // списываем с баланса токены вопроса и ответа

        // сохраняем сообщение в базе
        $message = Message::create([
            'chat_id' => $this->currentChatId,
            'content' => $this->message,
            'tokens' => $response->getInputTokens(),
        ]);

        // сохраняем ответ чата
        $responseMessage = Message::create([
            'chat_id' => $this->currentChatId,
            'content' => $response->getMessage(),
            'tokens' => $response->getOutputTokens(),
            'response_for' => $message->id,
        ]);

        // добавляем в чат
        $this->response[] = $message;
        $this->response[] = $responseMessage;

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

    public function openChat($chatId)
    {
        $chat = (new ChatService($chatId))->getChat();

        if ($chat) {

            // перестраиваем дерево чатов
            $this->currentChatId = $chat->id;
            $this->chats = $this->chats;

            // выводим историю сообщений
            $this->response = Message::where('chat_id', $chat->id)
                ->orderBy('created_at')
                ->get();;
        }
    }

    public function render()
    {
        return view('livewire.chat');
    }
}


