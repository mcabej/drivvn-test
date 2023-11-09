# Drivvn Backend Task - Symfony

[Go implementation](https://github.com/mcabej/backend-task)

## Requirements
- Docker

## Starting up
1. Run `docker compose up --build -d`
2. Run `docker exec -it -w /opt/app drivvn-test-php-fpm-1 php bin/console doctrine:migrations:migrate`
3. API is now ready at https://localhost:9000/api/car

## Run Test
1. Run `docker exec -it -w /opt/app drivvn-test-php-fpm-1 php bin/phpunit`

## Limitations
- No frontend
- No api endpoints for colors

