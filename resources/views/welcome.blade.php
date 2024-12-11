<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,500;1,500&display=swap" rel="stylesheet">

    </head>

    <body class="font-sans antialiased dark:bg-black dark:text-white/50">

<div style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><symbol viewBox="0 0 24 24" xml:space="preserve" id="check-icon" xmlns="http://www.w3.org/2000/svg"><path d="M18.3 6.3 9.1 16.4l-2.3-3c-.3-.4-1-.5-1.4-.2-.4.3-.5 1-.2 1.4l3 4c.2.2.5.4.8.4.3 0 .5-.1.7-.3l10-11c.4-.4.3-1-.1-1.4-.3-.4-1-.4-1.3 0z"/></symbol><symbol viewBox="0 0 24 24" xml:space="preserve" id="cross-icon" xmlns="http://www.w3.org/2000/svg"><path d="M5.3 18.7c.2.2.4.3.7.3s.5-.1.7-.3l5.3-5.3 5.3 5.3c.2.2.5.3.7.3s.5-.1.7-.3c.4-.4.4-1 0-1.4L13.4 12l5.3-5.3c.4-.4.4-1 0-1.4s-1-.4-1.4 0L12 10.6 6.7 5.3c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4l5.3 5.3-5.3 5.3c-.4.4-.4 1 0 1.4z"/></symbol></svg></div>

<header class="header">
    <nav class="nav">
        <a href="#how-it-works">Как работает</a>
        <a href="#community">Отзывы</a>
        <a href="#download">Скачать</a>
        <a href="#faq">FAQ</a>
    </nav>
</header>
@if (Route::has('login'))
    <nav class="auth_block">
        @auth
            <a
                href="{{ url('/dashboard') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Перейти к чату
            </a>
        @else
            <a
                href="{{ route('login') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Войти
            </a>

            @if (Route::has('register'))
                <a
                    href="{{ route('register') }}"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Регистрация
                </a>
            @endif
        @endauth
    </nav>
@endif
<section class="hero">
    <div class="hero-content">
        <h1>ChatGPT на русском и другие нейросети</br> в одном сервисе</h1>
        <p>ProstoGPT работает без VPN на основе популярных нейросетей. Используйте бесплатно!</p>
        <button class="cta-button">Использовать бесплатно</button>
    </div>
    <div class="hero-image">
        <img src="{{ asset('images/photo.jpg') }}" alt="AI Interface">
    </div>
</section>

<div class="align_center">
    <section class="how-it-works">
        <h2>Как работает ProstoGPT?</h2>
        <div class="columns">
            <div class="left-column">
                <div class="icons">
                    <img src="{{ asset('images/icon1.png') }}" alt="ChatGPT" />
                    <img src="{{ asset('images/icon2.png') }}" alt="SomeOtherAI" />
                    <img src="{{ asset('images/icon3.png') }}" alt="SomeAI" />
                    <img src="{{ asset('images/icon4.png') }}" alt="DALL-E" />
                </div>
                <ul class="cons-list">
                    <li><span class="cross">
    <svg><use href="#cross-icon"></use></svg>
</span> Платная версия от $20 с зарубежной карты</li>
                    <li><span class="cross"><svg><use href="#cross-icon"></use></svg></span> В пиковую загруженность не работает</li>
                    <li><span class="cross"><svg><use href="#cross-icon"></use></svg></span> Блокирует российских пользователей</li>
                    <li><span class="cross"><svg><use href="#cross-icon"></use></svg></span> Интерфейс на английском</li>
                </ul>
            </div>
            <div class="center-column">
                <p>
                    Мы подключаемся к платной версии Chat GPT от OpenAI и другим популярным нейросетям,
                    адаптируем их для России и делаем открытыми.
                </p>
            </div>
            <div class="right-column">
                <div class="chad-logo">
                    <img src="{{ asset('images/chad-logo.png') }}" alt="AI logo"/>
                </div>
                <ul class="pros-list">
                    <li><span class="check">
    <svg><use href="#check-icon"></use></svg>
</span> Поддерживает русский язык и интерфейс
                    </li>
                    <li><span class="check">
    <svg><use href="#check-icon"></use></svg>
</span> Быстрые ответы без очереди и остановок на час
                    </li>
                    <li><span class="check">
    <svg><use href="#check-icon"></use></svg>
</span> Доступ без VPN
                    </li>
                    <li><span class="check">
    <svg><use href="#check-icon"></use></svg>
</span> Не нужен номер телефона и иностранная карта
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="features-grid">
            <div class="feature-card">
                <img src="{{ asset('images/create-content-icon.svg') }}" alt="Создайте контент" />
                <h3>Создайте контент</h3>
                <p>Генерируйте тексты, статьи, сценарии, рекламные слоганы и многое другое за считанные секунды</p>
            </div>
            <div class="feature-card">
                <img src="{{ asset('images/save-time-icon.svg') }}" alt="Экономьте время" />
                <h3>Экономьте время</h3>
                <p>Автоматизируйте рутинные задачи и сосредоточьтесь на творчестве и развитии бизнеса</p>
            </div>
            <div class="feature-card">
                <img src="{{ asset('images/learn-icon.svg') }}" alt="Обучайтесь" />
                <h3>Используйте в учебе</h3>
                <p>Ищите любую информацию, решайте тесты, создавайте рефераты в один клик</p>
            </div>
            <div class="feature-card">
                <img src="{{ asset('images/support-icon.svg') }}" alt="Поддержка" />
                <h3>Создавайте код</h3>
                <p>Редактируйте и создавайте любой код, учитесь новому и исправляйте ошибки</p>
            </div>
            <div class="feature-card">
                <img src="{{ asset('images/text-icon.svg') }}" alt="Поддержка" />
                <h3>Улучшайте текст</h3>
                <p>Редактируйте любой текст, увеличивайте оригинальность, создавайте лучший текст под любые задачи</p>
            </div>
        </div>
    </section>


    <section id="community" class="community">
        <h2>Сообщество и отзывы</h2>
        <div class="review-grid">
            <div class="review">
                <h3>Вита</h3>
                <p>Спасибо за бот! Использовала для копирайта в соцсетях, подкинул классные идеи для рубрик) Работает быстрее, чем обычный и не тупит, так как не нужен VPN.</p>
            </div>
            <div class="review">
                <h3>Маша</h3>
                <p>Суперский продукт. Упрощает множество задач. Это станет максимально комфортным механизмом для тех, кто все время откладывал мороку с регистрацией на оригинальном сайте.</p>
            </div>
            <div class="review">
                <h3>Данил</h3>
                <p>Реально крутой бот!!! Парился с научкой пол года, покупал турецкую карту, для регистрации, потом переводил с английского... А тут, быстро, без очереди и без всяких заморочек!</p>
            </div>
            <div class="review">
                <h3>Миша</h3>
                <p>Крутяк! Юзаю, чтобы писать код, для вуза функционала хватает. Поддерживает разные языки программирования. Нет проблем с регистрацией, не нужна фейк симка.</p>
            </div>
            <div class="review">
                <h3>Денис</h3>
                <p>Пользовался для проги в универе на python все работает четко, спасибо.</p>
            </div>
            <div class="review">
                <h3>Саша</h3>
                <p>Очень быстро и удобно все работает, рад что теперь не нужно париться с VPN)! Работает быстрее чем оригинальный и на русском ответы получаются на много лучше!</p>
            </div>
        </div>
        <button class="cta-button">Начать бесплатно</button>
    </section>

    <section id="faq" class="faq">
        <h2>Часто задаваемые вопросы</h2>
        <div class="faq-item">
            <button class="faq-question">Как и на какой версии работает ProstoGPT AI?</button>
            <div class="faq-answer">
                <p>В нашем сервисе доступны самые современные нейросети.</p>
                <p>Чатбот был основан на оригинальной языковой модели GPT-3,5 от OpenAI. Модель обучали с помощью массива текстов из интернета и человеческой системы обучения. ChatGPT иногда может выдавать неправильные ответы на непопулярные локальные запросы в России или вопросы до 2021 года. Мы рекомендуем проверять, являются ли ответы модели точными, а также использовать ее для популярных вопросов.</p>
                <p>Сейчас на замену GPT-3.5 пришла GPT-4o Mini, гораздо более современная модель. Модель выпущенна 18 июля 2024, имеет больший контекст диалога и обладает знаниями событий до октября 2023 года.</p>
                <p>Также доступна GPT-4o: она выдаёт более качественные ответы, но при её использовании расходуется больше слов. Сейчас это самая передовая текстовая нейросеть.</p>
                <p>Кроме того, доступны версии Claude 3 Haiku и Opus, которые отличаются между собой скоростью, ценой и качеством ответов (Opus - самая умная, Haiku - самая быстрая и дешевая). По некоторым отзывам, модели Claude отвечают "человечнее" чем GPT.</p>
                <p>Недавно добавили Claude 3.5 Sonnet - она умнее "третьей" Opus, и при этом в разы дешевле!</p>
                <p>Для генерации изображений используются нейросети Midjourney 5.2 и 6, Stable Diffusion и DALL·E 3. Чтобы бот нарисовал изображение, просто попросите его об этом (например, "Нарисуй мост через реку").</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Что будет, если израсходуются лимиты слов раньше окончания месяца?</button>
            <div class="faq-answer">
                <p>В таком случае, вы сможете не дожидаясь следующего месяца переоформить подписку. Можно взять тот же тарифный план или другой. Лимит будет расширен незамедлительно, а следующее списание средств будет осуществлено через месяц после последнего (только что оформленного) платежа.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Как считается количество слов, указанное в тарифах?</button>
            <div class="faq-answer">
                <p>Учитывается:</p>
                <p>Введённый текст;</p>
                <p>Сгенерированный нейросетью текст;</p>
                <p>Текст предыдущих сообщений, необходимый, чтобы нейросеть учитывала контекст диалога и обучалась.</p>
                <p>По умолчанию нейросеть в конкретном чате запоминает и обрабатывает последние 2000-64000 символов (250 - 8000 слов), в зависимости от настроек и выбранной модели.</p>
                <p>При отключении контекста нейросеть не будет тратить силы на учет верхних сообщений — будут считаться только введенный и сгенерированный текст.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Как считается количество слов, указанное в тарифах?</button>
            <div class="faq-answer">
                <p>Учитывается:</p>
                <p>Введённый текст;</p>
                <p>Сгенерированный нейросетью текст;</p>
                <p>Текст предыдущих сообщений, необходимый, чтобы нейросеть учитывала контекст диалога и обучалась.</p>
                <p>По умолчанию нейросеть в конкретном чате запоминает и обрабатывает последние 2000-64000 символов (250 - 8000 слов), в зависимости от настроек и выбранной модели.</p>
                <p>При отключении контекста нейросеть не будет тратить силы на учет верхних сообщений — будут считаться только введенный и сгенерированный текст.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Почему сервис платный?</button>
            <div class="faq-answer">
                <p>Мы используем платную приоритетную версию Chat GPT от OpenAI. Оплачиваем ее зарубежом и предоставляем в России для тех, кому неудобно ограничивать себя, ждать в очереди на обработку и использовать VPN.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Если у меня возникнут вопросы или сложности , мне помогут?</button>
            <div class="faq-answer">
                <p>Да, вы можете задать вопрос или написать техническую проблему в Telegram-чате в разделе поддержка и мы ответим.</p>
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">Как отключить подписку?</button>
            <div class="faq-answer">
                <p>Чтобы отключить автопродление, нужно зайти в личный кабинет и нажать кнопку "Отменить автопродление". При оплате по СБП автопродление не оформляется, поэтому опция его отключения не видна.

                    После отключения автопродления уже оплаченная подписка всё равно продолжит работать до окончания срока действия или до окончания лимита слов.</p>
            </div>
        </div>
    </section>
</div>

<footer class="footer">
    <p>© {{ date('Y') }} {{ config('app.name') }}</p>
</footer>


<!-- Styles / Scripts -->
@vite(['resources/css/landing/style.scss', 'resources/js/landing/main.js'])

    </body>
</html>
