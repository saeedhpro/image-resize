

## How to run

run this command in terminal:

php artisan schedule:run


or add this to crontab

* * * * * php /path/to/artisan images:resize >> /dev/null 2>&1

