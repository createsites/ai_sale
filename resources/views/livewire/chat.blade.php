<div class="flex">
    {{-- Левое меню с чатами --}}
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

    {{-- Текущий чат --}}
    <div class="w-3/4 bg-white p-6 rounded shadow-md">
        <div id="request_ai">
            <form wire:submit="sendMessage" class="mb-4">
                @csrf
                <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Спроси у ИИ:</label>
                <div class="flex items-center gap-3">
                    <input type="text" id="message" wire:model="message" required autocomplete="off" class="w-full p-2 border rounded shadow">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Отправить
                    </button>
                </div>
            </form>
        </div>

        <!-- Вывод ошибок -->
        @error('message')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        @if ($response)
            <div class="flex flex-col">
                @foreach ($response as $message)
                    @if (!$message->response_for)
                    <div class="w-1/2 self-end rounded-tl-[15px] rounded-bl-[15px] rounded-br-[15px] bg-gray-100 p-4 border border-gray-300 mt-4">
                    @else
                    <div class="p-4 mt-4">
                    @endif
                        {{ $message->content }}
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@section('styles')
    <style>
        #request_ai.fixed {
            left: 0;
            top: 0;
            width: 100%;
            background-color: #fff;
            padding: 15px 30px;
        }
    </style>
@endsection

@section('scripts')
    <script type="text/javascript">
        // Прилепляем форму для вопроса ИИ сверху при прокрутке страницы
        // величина скролла, при которой форма станет position: fixed
        const SCROLL_POINT = 330;
        const requestForm = document.getElementById('request_ai');

        window.addEventListener('scroll', function() {
            if (window.scrollY >= SCROLL_POINT) {
                requestForm.classList.add('fixed');
            }
            else {
                requestForm.classList.remove('fixed');
            }
        });
    </script>
@endsection
