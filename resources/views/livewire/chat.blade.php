<div class="bg-white p-6 rounded shadow-md">
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

    @if ($response)
        @foreach ($response as $message)
        <div class="response bg-gray-100 p-4 border border-gray-300 rounded mt-4">
            <p>{{ $message }}</p>
        </div>
        @endforeach
    @endif
</div>
