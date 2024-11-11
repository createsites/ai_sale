<?php

namespace App\Livewire;

use App\Adapters\OpenAiAdapter;
use App\Models\Message;
use App\Services\FakeOpenAIService;
use App\Services\OpenAIService;
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
        // в сессии ид чата нет - создаем его
        if (!$chatId) {
            // todo определять имя чата
            // todo сделать имя nullable и оставлять пустым у текущих чатов созданных автоматом
            $chat = new \App\Models\Chat();
            $chat->name = 'New chat';
            $chat->user_id = auth()->user()->id;
            $chat->save();
            // запоминаем в сессии
            session(['chat_id' => $chat->id]);
        }
        // список последних чатов
        // переменная $this->chats транслируется в шаблон
        $this->chats = \App\Models\Chat::orderBy('created_at', 'desc')
            ->take(10) // Ограничиваем до 10 записей
            ->get()
            ->all(); // коллекцию в массив
        // todo проходиться по всем чатам, кроме текущего, и для безымянных присваивать имя из первого сообщения
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

    public function render()
    {
        return view('livewire.chat');
    }
}


