<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Главная') | {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        @yield('styles')
    </head>
    <body class="font-sans antialiased">

        @if (session('success'))
            <div class="hide_after_delay fixed top-20 right-5 bg-green-500 text-white py-2 px-4 rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        <x-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @livewire('navigation-menu')

            <header class="bg-white dark:bg-gray-800 shadow">
                <div x-data="balance"
                     class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <p>Баланс: <span x-text="balance"></span> руб. </p>
                </div>
            </header>

            <!-- Page Heading -->
            @if (isset($additional_header))
                <?php
                // для вывода этого блока нужно в файле, который подключает layout создать
                // элемент <x-slot name="additional_header">
                // например в dashboard.blade.php
                ?>
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $additional_header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

    @yield('scripts')
        <script>
            // создаем Alpine компонент, задаем ему баланс
            // навешиваем слушатель события обновления баланса, чтобы уменьшать при списывании
            // событие инициируется из Chat Livewire Controller
            document.addEventListener('alpine:init', () => {
                Alpine.data('balance', () => ({
                    // при инициализации задаем баланс из php
                    // это округленный баланс, он выводится на странице
                    balance: {{
                        auth()->user()->credits
                            ? round(auth()->user()->credits->amount, 2)
                            : 0
                        }},
                    // неокругленное значение баланса, чтобы правильно считать
                    realBalance: {{ auth()->user()->credits ? auth()->user()->credits->amount : 0 }},
                    init() {
                        // событие обновления баланса
                        // оно диспатчится в php в livewire компоненте Chat
                        document.addEventListener('balance_updated', event => {
                            // вычисляем новый баланс
                            this.realBalance += event.detail.balanceChange;
                            // меняем баланс в шапке
                            // округляем до двух знаков после запятой
                            this.balance = parseFloat(this.realBalance.toFixed(2));
                        });
                    },
                }));
            });
        </script>
    </body>
</html>
