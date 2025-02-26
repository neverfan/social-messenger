start:
	make up
	make scale-3
	make install
	sleep 10 && make migrate
	make seed

install:
	docker compose run --rm php-fpm composer install --ignore-platform-reqs

update:
	docker compose run --rm php-fpm composer update --ignore-platform-reqs

up:
	docker compose up -d

migrate:
	docker compose run --rm php-fpm php artisan migrate:fresh

tinker:
	docker compose run --rm php-fpm php artisan tinker

seed:
	docker compose run --rm php-fpm php -d memory_limit=2G artisan db:seed --class=DatabaseSeeder

scale-3:
	docker compose up -d --scale worker=3

scale-5:
	docker compose up -d --scale worker=5
