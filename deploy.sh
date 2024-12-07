#!/bin/bash

# Путь к директории на сервере, куда нужно развернуть приложение
APP_DIR=~/www/prostogpt.ru

echo '>>> Обновляем код'
cd $APP_DIR
git pull origin master

echo '>>> Устанавливаем зависимости composer'
php composer.phar install --no-interaction --prefer-dist --optimize-autoloader

echo '>>> Билдим docker образ и стартуем контейнер'
./vendor/bin/sail up --build -d

echo '>>> Применяем миграции'
./vendor/bin/sail artisan migrate

echo '>>> Установка npm зависимостей'
./vendor/bin/sail npm ci

echo '>>> Сборка vite'
./vendor/bin/sail npm run build
