.PHONY: help build up down restart logs ps clean migrate seed fresh test

help:
	@echo "Available commands:"
	@echo "  make build      - Build Docker images"
	@echo "  make up         - Start Docker containers"
	@echo "  make down       - Stop Docker containers"
	@echo "  make restart    - Restart Docker containers"
	@echo "  make logs       - View Docker logs"
	@echo "  make ps         - List Docker containers"
	@echo "  make clean      - Remove Docker containers and volumes"
	@echo "  make migrate    - Run database migrations"
	@echo "  make seed       - Run database seeders"
	@echo "  make fresh      - Drop all tables and re-run migrations with seeds"
	@echo "  make test       - Run tests"

build:
	docker-compose build --no-cache

up:
	docker-compose up -d

down:
	docker-compose down

restart:
	docker-compose down
	docker-compose up -d

logs:
	docker-compose logs -f

ps:
	docker-compose ps

clean:
	docker-compose down -v
	docker-compose rm -f

migrate:
	docker-compose exec app php artisan migrate

seed:
	docker-compose exec app php artisan db:seed

fresh:
	docker-compose exec app php artisan migrate:fresh --seed

init: build up
