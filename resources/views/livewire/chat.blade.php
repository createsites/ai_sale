<div class="flex">
    <!-- Левое меню с чатом -->
    <div class="w-1/4 bg-gray-100 p-4 rounded shadow-md">
        <h2 class="text-gray-700 text-lg font-bold mb-4">Предыдущие чаты</h2>
        <ul>
            @foreach ($chats as $chat)
                <li class="mb-2">
                    <a href="#" wire:click.prevent="openChat({{ $chat->id }})"
                       class="block bg-gray-200 hover:bg-gray-300 text-gray-700 p-2 rounded">
                        {{ $chat->name ?? 'Чат #' . $chat->id }}
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
            @foreach ($response as $message)
            <div class="response bg-gray-100 p-4 border border-gray-300 rounded mt-4">
                <p>{{ $message }}</p>
            </div>
            @endforeach
        @endif
    </div>
</div>
