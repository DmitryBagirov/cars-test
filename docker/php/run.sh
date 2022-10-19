#!/bin/sh
sh docker/wait-for.sh ${DB_HOST}:${DB_PORT}
composer install --prefer-dist --no-progress --no-interaction --no-ansi --no-suggest
#php artisan migrate
exec $@
