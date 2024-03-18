# Подключает файл с переменными окружения
include .env

# Отключает вывод сообщений make
.SILENT:

# Объявляет переменные
CONTAINER_NAME := $(COMPOSE_PROJECT_NAME)-php-fpm

# Указывает фиктивные цели
.PHONY: start stop restart php composer phpcs phpcbf sh

# Запускает проект
start:
	docker-compose up -d --build php-fpm rabbitmq mysql phpmyadmin

# Останавливает проект
stop:
	docker-compose down

# Удаляет папку vendor и файл composer.lock
make clean:
	-rm -rf src/vendor
	-rm src/composer.lock

# Перезапускает проект
restart:
	@make stop
	@sleep 5
	@make start

# Запускает PHP скрипт
# Пример: make php, make php public/index.php, make php -- -v, make php -- - a
php:
	docker exec -it $(CONTAINER_NAME) php $(or $(filter-out $@,$(MAKECMDGOALS)),public/index.php)

# Запускает Composer
# Пример: make composer install, make composer update, make composer require nikic/fast-route,
# make composer remove nikic/fast-route, make composer dump-autoload
composer:
	docker exec -it $(CONTAINER_NAME) composer $(filter-out $@,$(MAKECMDGOALS))

# Запускает CodeSniffer
phpcs:
	docker exec -it $(CONTAINER_NAME) ./vendor/bin/phpcs $(filter-out $@,$(MAKECMDGOALS))

# Запускает CodeSniffer Fixer
phpcbf:
	docker exec -it $(CONTAINER_NAME) ./vendor/bin/phpcbf $(filter-out $@,$(MAKECMDGOALS))

# Подключается к оболочке sh внутри контейнера
sh:
	docker exec -it $(CONTAINER_NAME) sh

# Добавляет правило для игнорирования неизвестных целей
%:
	@:
