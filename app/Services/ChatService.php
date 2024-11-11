<?php


namespace App\Services;


class ChatService
{
    const SESSION_KEY = 'chat_id';
    const LAST_CHATS_LIMIT = 10;
    const AUTO_NAME_SYMBOLS = 35;

    private $chat;

    public function __construct()
    {
        // пытаемся получить из сессии
        $this->chat = $this->getFromSession();

        // в сессии ид чата нет - создаем его
        if (!$this->chat || $this->isExpired()) {
            $this->add();
        }
    }

    private function getFromSession()
    {
        $chat = null;
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
        }
        return $chat;
    }

    public function add()
    {
        // если текущего чата нет в сессии, ищем последний
        if (!$this->chat) {
            $lastChat = auth()->user()->lastChat;
            if ($lastChat) {
                $this->chat = $lastChat;
            }
        }

        // если у пользователя еще нет чатов - пропускаем переименование
        if ($this->chat) {
            // перед добавлением нового, переименовываем текущий чат, если у него нет имени
            if (!$this->chat->name) {
                // если у чата нет ни одного сообщения - ничего не создаем, оставляем его
                if ($this->chat->messages->count() == 0) {
                    return $this->chat;
                }
                else {
                    $this->renameChat();
                }
            }
        }

        // создаем новый
        $chat = new \App\Models\Chat();
        // у нового чата имя пустое
        // когда он переместится в архив ему присвоится имя от начала первого сообщения
        $chat->user_id = auth()->user()->id;
        $chat->save();
        // запоминаем в сессии
        session([static::SESSION_KEY => $chat->id]);

        $this->chat = $chat;

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

    public function renameChat($name = '')
    {
        // определяем имя
        if (!$name) {
            $firstMessage = $this->chat->messages->first();
            $name = substr($firstMessage->content, 0, static::AUTO_NAME_SYMBOLS);
        }
        $this->chat->name = $name;
        $this->chat->save();
    }
}
