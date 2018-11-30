# File Downloading Application

This application is able to download particular resource by provided urls.


### Quick start

```sh
composer install & cp .env.example .env & php artisan key:generate
```

Change in .env database configs and change QUEUE_CONNECTION=database


After run this commands

```sh
php artisan migrate --seed
php artisan queue:listen --timeout=0 --tries=1
```
