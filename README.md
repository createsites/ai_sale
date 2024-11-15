# Перепродажа AI

За основу берем сайт [chadgpt.ru](https://chadgpt.ru/)

## Настройка

Важно указать в .env
1. APP_URL=https://ai_sale.local
1. VK_REDIRECT_URI=https://ai_sale.local/auth/vk/callback (именно https)

## Принцип работы подсветки синтаксиса и парсинга markdown в ответах chatGpt

Обработка происходит на стороне клиента.

В шаблоне chat.blade.php есть инлайн скрипт в секции @script.
В нем мы можем отлавливать события инициализации и обновления LiveWire
```Livewire.hook('morph.updated'...```

Скрипт подсветки работает в `resources/js/app.js`
т.к. этот файл обрабатывается vite и там работает импорт npm модулей.

Передача события из скрипта blade шаблона в app.js осуществляется с помощью кастомных событий.

Отлавливая обновление Livewire в chat.blade.php, мы выполняем dispatch собственного события, а app.js его слушает.
