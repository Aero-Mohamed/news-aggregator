# backend/init.sh
#!/bin/bash

echo "🔧 Running Laravel backend initialization..."

composer install --no-interaction --prefer-dist --optimize-autoloader

if [ -f artisan ]; then

    php -r "file_exists('.env') || copy('.env.example', '.env');"

    php artisan migrate --force

    php artisan passport:keys -n -q

    php artisan storage:link
    php artisan optimize
    php artisan cache:clear
    php artisan route:clear
fi

echo "✅ Laravel backend is initialized!"
