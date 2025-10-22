.PHONY: up down build restart logs shell composer

up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build

restart:
	docker-compose restart

logs:
	docker-compose logs -f

shell:
	docker-compose exec app bash

composer:
	docker-compose exec app composer $(filter-out $@,$(MAKECMDGOALS))

artisan:
	docker-compose exec app php artisan $(filter-out $@,$(MAKECMDGOALS))

migrate:
	docker-compose exec app php artisan migrate

test:
	docker-compose exec app php artisan test

%:
	@: