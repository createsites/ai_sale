<div class="flex">
    <!-- Левое меню с чатом -->
    <div class="w-1/4 p-4">
        <h2 class="text-gray-700 text-lg font-bold mb-4">Чаты:</h2>
        <a href="#" wire:click.prevent="createChat()"
           class="block bg-blue-500 hover:bg-blue-600 text-white p-2 mb-3 text-center rounded">
            Создать новый</a>
        <ul>
            @foreach ($chats as $index => $chat)
                <li class="mb-2">
                    @if ($currentChatId == $chat->id)
                    <a href="#"
                       class="border-indigo-400 border block bg-gray-200 hover:bg-gray-300 text-gray-700 p-2 rounded">
                    @else
                    <a href="#" wire:click.prevent="openChat({{ $chat->id }})"
                       class="border block bg-gray-200 hover:bg-gray-300 text-gray-700 p-2 rounded">
                    @endif
                        @if ($chat->name)
                            {{ $chat->name }}
                        @else
                            {{ $index ? 'Чат #' . $chat->id : 'Текущий чат' }}
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="w-3/4 bg-white p-6 rounded shadow-md">
        <form wire:submit="sendMessage" class="mb-4">
            @csrf
            <div>
                <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Спроси у ИИ:</label>
                <input type="text" id="message" wire:model="message" required autocomplete="off" class="w-full p-2 border rounded shadow">
            </div>
            <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Отправить
            </button>
        </form>

        <!-- Вывод ошибок -->
        @error('message')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        @if ($response)
            <div class="flex flex-col">
                @foreach ($response as $message)
                <div class="@if (!$message->response_for) w-1/2 self-end @endif bg-gray-100 p-4 border border-gray-300 rounded mt-4">
                    {{ $message->content }}
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
