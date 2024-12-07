#!/bin/bash

# Путь к директории на сервере, куда нужно развернуть приложение
APP_DIR=~/www/prostogpt.alexarg.com

echo '>>> Обновляем код'
cd $APP_DIR
git pull origin master

echo '>>> Устанавливаем зависимости composer'
/opt/plesk/php/8.3/bin/php composer.phar install --no-dev --prefer-dist

echo '>>> Применяем миграции'
/opt/plesk/php/8.3/bin/php artisan migrate

echo '>>> Установка npm зависимостей'
npm ci

echo '>>> Сборка vite'
npm run build
