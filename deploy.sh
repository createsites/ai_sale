#!/bin/bash

# Путь к директории на сервере, куда нужно развернуть приложение
APP_DIR=~/www/prostogpt.ru

echo '>>> Обновляем код'
cd $APP_DIR
git pull origin master

echo '>>> Устанавливаем зависимости composer'
php composer.phar install --no-interaction --prefer-dist --optimize-autoloader

# Это нужно чтобы освободить память на дохлом серваке
echo '>>> Останавливаем контейнеры, если были запущены'
./vendor/bin/sail down

echo '>>> Установка npm зависимостей'
npm ci

echo '>>> Сборка vite'
npm run build

# Запускаем обратно контейнеры
echo '>>> Билдим docker образ и стартуем контейнер'
./vendor/bin/sail up --build -d

echo '>>> Применяем миграции'
./vendor/bin/sail artisan migrate
