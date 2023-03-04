## installation

- install PHP and composer in your machine
- open terminal and navigate to the root directory of the project
- run `composer install`
- copy .env.example to .env
- run the following command `php artisan fruits:fetch`
- then run the following command to run the app `php artisan serve` then visit the url it gave, it should be http://127.0.0.1:8000 or use Valet if you have it installed
- Emails sent when Fruits added can be found in /storage/logs/laravel.log
