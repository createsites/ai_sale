#!/bin/bash

# Путь к директории на сервере, куда нужно развернуть приложение
#APP_DIR=/var/www/myapp

# Обновляем код
#cd $APP_DIR
git pull origin master

# применяем миграции
php artisan migrate

# Установка зависимостей, если нужно (например, для Node.js приложения)
npm install --production
npm run build

