## Порядок деплоя

**_git@github.com:MrDreek/SMMsos.git_**

**_composer install --no-dev_** установка зависимостей без require-dev

**_php -r "file_exists('.env') || copy('.env.example', '.env');"_**

**_php artisan key:generate_**

Указать необходимые данные в файле .env (Подключение к базе, настройки прокси, ключи от АПИ)

_**php artisan config:cache**_  // команда для кеширования настроек окружения

