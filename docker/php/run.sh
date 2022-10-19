#!/bin/sh
composer install --prefer-dist --no-progress --no-interaction --no-ansi --no-suggest
php artisan migrate
exec $@
