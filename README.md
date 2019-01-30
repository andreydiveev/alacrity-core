# Install

``` bash
composer require alacrity/core
```

### Setup

Apply migrations:

```bash
php artisan migrate
```

Generate default clients (optional):

```
php artisan passport:client --personal
php artisan passport:client --password
```
