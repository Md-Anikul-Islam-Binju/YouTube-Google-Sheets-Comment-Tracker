# Project Setup
composer update
# Project Setup .env
cp .env.example .env
# Project Setup Key
php artisan key:generate
# Project Setup migrate
php artisan migrate
# Admin Create
php artisan db:seed

# if test menually then run comand
php artisan youtube:fetch

# if test in your local pc useing windows then setup on OS after setup run comad

php artisan schedule:run

php artisan schedule:work
