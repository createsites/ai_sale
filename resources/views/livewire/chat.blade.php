<div class="flex flex-col md:flex-row">
    {{-- Левое меню с чатами --}}
    <div x-data="{ open: window.innerWidth > 768 }"
         x-init="
            window.addEventListener('resize', () => {
                open = window.innerWidth > 768;
            });
        "
         class="md:w-1/4 p-4 relative">
        <button @click="open = !open" class="absolute -top-5 right-5 md:hidden"
            x-text="open ? 'Скрыть чаты' : 'Показать чаты'">
        </button>
        <div x-show="open">
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
    </div>

    {{-- Текущий чат --}}
    <div class="md:w-3/4 bg-white p-6 rounded shadow-md">
        <div id="request_ai">
            <form wire:submit="sendMessage" class="mb-4">
                @csrf
                <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Спроси у ИИ:</label>
                <div class="flex items-center gap-3">
                    <input type="text" id="message" wire:model="message" required autocomplete="off" class="w-full p-2 border rounded shadow">
                    <button @if ($disableSendButton) disabled @endif type="submit" id="message_btn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Отправить
                    </button>
                </div>
            </form>
        </div>

        <!-- Вывод ошибок -->
        @error('message')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        @error('common')
        <span class="text-red-500">{{ $message }}</span>
        @enderror

        @if ($response)
            <div id="chat_history" class="flex flex-col">
                @foreach ($response as $message)
                    <div class="@if (!$message->response_for)md:w-1/2 self-end rounded-tl-[15px] rounded-bl-[15px] rounded-br-[15px] bg-gray-100 border border-gray-300 @endif p-4 mt-4">
                        @if ($message->response_for)
                        <div class="response_ai">
                        @endif
                            {{ $message->content }}
                        @if ($message->response_for)
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>


@script
<script>
    // событие обновления компонентов на странице
    // отлавливаем его, чтобы задиспатчить свой customEvent,
    // который поймаем в app.js и там подсветим синтаксис
    Livewire.hook('morph.updated', ({ el, component }) => {
        // ловим нужный элемент DOM с историей чата
        if (el.id === 'chat_history') {
            const customEvent = new CustomEvent('chat.updated', {
                // передаем DOM элемент
                detail: { elem: el }
            });
            document.dispatchEvent(customEvent);
        }
    });
</script>
@endscript
