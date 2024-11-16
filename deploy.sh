#!/bin/bash

# Путь к директории на сервере, куда нужно развернуть приложение
APP_DIR=www/prostogpt.alexarg.com

# Обновляем код
cd $APP_DIR
git pull origin master

# применяем миграции
php artisan migrate

# Установка зависимостей
npm ci

# сборка vite
npm run build
