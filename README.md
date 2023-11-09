# Drivvn Backend Task - Symfony

[Go implementation](https://github.com/mcabej/backend-task)

## Requirements
- Docker

## Starting up
1. Run `docker compose up --build -d`
2. Run `docker exec -it -w /opt/app drivvn-test-php-fpm-1 composer install`
3. Run `docker exec -it -w /opt/app drivvn-test-php-fpm-1 php bin/console doctrine:migrations:migrate`
4. Run `docker exec -it -w /opt/app drivvn-test-php-fpm-1 php bin/console doctrine:database:create`
5. API is now ready at https://localhost:9000/api/car/cars

## Endpoints
[POSTMAN](https://www.postman.com/avionics-engineer-99532960/workspace/public-apis/request/27922445-716d524a-60fb-4132-8368-6fd60b684181)
- /api/car/cars [GET]
- /api/car/create [POST]
- /api/car/:id [GET]

## Run Test
1. Run `docker exec -it -w /opt/app drivvn-test-php-fpm-1 php bin/phpunit`

## Limitations
- No frontend
- No api endpoints for colors
- No method for updating car

