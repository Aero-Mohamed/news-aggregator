# backend/init.sh
#!/bin/bash

echo "🔧 Running Laravel backend initialization..."

composer install --no-interaction --prefer-dist --optimize-autoloader

if [ -f artisan ]; then

    php -r "file_exists('.env') || copy('.env.example', '.env');"

    php artisan key:generate
    php artisan migrate:fresh --seed --force

    php artisan passport:keys -n -q
    php artisan passport:client --personal --name="Personal Access Client" --provider=users --no-interaction

    php artisan storage:link
    php artisan cache:clear
    php artisan route:clear
    php artisan optimize

    php artisan app:news-sync
fi

find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod 644 ./docker/mysql/my.cnf
chmod -R 777 storage bootstrap/cache
chmod 755 init.sh vendor/bin/*
chmod 600 storage/oauth-*.key
chown www-data:www-data /var/www/storage/oauth-*.key


echo "✅ Laravel backend is initialized!"
