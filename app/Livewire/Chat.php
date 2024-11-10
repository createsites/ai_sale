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
            // test
            // todo определять имя чата
            $chat = new \App\Models\Chat();
            $chat->name = 'New chat';
            $chat->user_id = auth()->user()->id;
            $chat->save();
            // запоминаем в сессии
            session(['chat_id' => $chat->id]);
        }
        // список чатов
        // последние
        $this->chats = \App\Models\Chat::orderBy('created_at', 'desc') // Сортировка по новизне
            ->take(10) // Ограничиваем до 10 записей
            ->get()
            ->all(); // коллекцию в массив
        // текущий
        array_unshift($this->chats, $chat);
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

        // сохраняем сообщение в базе
        Message::create([
            'chat_id' => session('chat_id', null),
            'content' => $response->getMessage(),
            'tokens' => $response->getInputTokens(),
        ]);

        // Очищаем поле после отправки
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chat');
    }
}


