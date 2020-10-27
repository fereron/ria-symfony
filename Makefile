init: docker-down docker-pull docker-build docker-up app-init

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

app-init: app-install-composer app-migrate

app-install-composer:
	docker-compose run --rm php-cli composer install

app-migrate:
	docker-compose run --rm php-cli php bin/console doctrine:migrations:migrate --quiet

app-test:
	docker-compose run --rm php-cli ./bin/phpunit