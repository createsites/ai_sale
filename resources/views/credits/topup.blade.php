<x-app-layout>
    @section('title', 'Пополнить баланс')
    <div class="py-12">
        <form action="{{ route('credits.process') }}" method="POST" class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
            @csrf
            <div class="mb-4">
                <label for="amount" class="block text-gray-700 text-sm font-semibold mb-2">
                    Введите количество кредитов для пополнения:
                </label>
                <input type="number" name="amount" min="1" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" />
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                Пополнить
            </button>
        </form>
    </div>
</x-app-layout>
