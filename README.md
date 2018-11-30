# File Downloading Application

This application is able to download particular resource by provided urls.


### Quick start Steps

###### 1. SETUP ENVIRNMENT
see available env variables in .env.example and copy to .env file with `initializing you database credentials`!

```sh
composer install & cp .env.example .env & php artisan key:generate
```
###### 2. RUN MIGRATIONS
```sh
php artisan migrate --seed
```
###### 3. RUN QUEUE LISTENER
```sh
php artisan queue:listen --timeout=0 --tries=1
```
###### 4. LUNCH SERVER
```sh
php artisan serve
```
