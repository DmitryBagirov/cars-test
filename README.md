### Setup with Docker
#### Config and startup
* `cp .env.example .env` - to make a .env configuration file from the .env.example
* `docker-compose up` - to run docker services form compose file
#### Tests
* `docker-compose run php -t && DB_HOST=127.0.0.1 php artisan test`
### Commands 
* `php artisan cars:init-models` - initialize car brands with models
* `php artisan cars:generate` - generate cars for existing models
* `php artisan users:make {email} {password}` - make a user
