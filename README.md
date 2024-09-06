## How to use Project Penjualan

In this case I assume you have the following requirements:

- [Chrome](https://www.google.com/intl/id/chrome/) Or [Firefox](https://www.mozilla.org/id/firefox/new/)
- [Apache](https://httpd.apache.org/) Or [Nginx](http://nginx.org/en/download.html)
- [PHP](https://www.php.net/downloads)
- [Composer](https://getcomposer.org/download/)


``` bash
git clone https://github.com/zakiamansyah/penjualans
cd penjualans
composer install
composer update
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

> **Happy Coding**. 😆
