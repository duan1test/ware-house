cd /var/www/html/cs-warehouse
git checkout develop
git pull origin develop
npm run build
docker exec app composer i
docker exec app php artisan migrate --force
docker exec app php artisan optimize
exit
