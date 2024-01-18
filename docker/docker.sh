sleep 10
# chown -R mysql:mysql /var/run/mysqld
npm install
npm run build
php artisan migrate --force
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan db:see
apache2-foreground