<?php


namespace App\Services;


class ChatService
{
    const SESSION_KEY = 'chat_id';
    const LAST_CHATS_LIMIT = 10;

    private $chat;

    public function __construct()
    {
        // пытаемся получить из сессии
        $chat = $this->getFromSession();

        // в сессии ид чата нет - создаем его
        if (!$chat || $this->isExpired()) {
            $this->add();
        }
    }

    private function getFromSession()
    {
        $chatId = session(static::SESSION_KEY, null);
        // ели в сессии есть chat_id
        if ($chatId) {
            // проверяем его наличие в базе
            $chat = \App\Models\Chat::find($chatId);
            // и принадлежность к текущему пользователю
            if (!$chat || $chat->user->id !== auth()->user()->id) {
                session()->forget(static::SESSION_KEY);
                return null;
            }
            // если все ок
            $this->chat = $chat;
        }
        return $this->chat;
    }

    public function add()
    {
        $chat = new \App\Models\Chat();
        // у нового чата имя пустое
        // когда он переместится в архив ему присвоится имя от начала первого сообщения
        $chat->user_id = auth()->user()->id;
        $chat->save();
        // запоминаем в сессии
        session([static::SESSION_KEY => $chat->id]);

        $this->chat = $chat;

        // переименовываем пустые чаты
        // todo проходиться по всем чатам, кроме текущего, и для безымянных присваивать имя из первого сообщения

        return $this->chat;
    }

    public function getChat()
    {
        return $this->chat;
    }

    public function getLastChats()
    {
        return \App\Models\Chat::orderBy('created_at', 'desc')
            ->take(static::LAST_CHATS_LIMIT)
            ->get()
            ->all(); // коллекцию в массив
    }

    // todo сделать чтобы старый чат пересоздавался
    private function isExpired()
    {
        return false;
    }
}
