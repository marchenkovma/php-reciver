# Устанавливает переменную среды
ARG PHP_VERSION

# Использует базовый образ PHP с использованием переменной среды
FROM php:${PHP_VERSION}-fpm

# Обновляет список пакетов и устанавливает необходимые пакеты
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    vim \
    unzip \
    libicu-dev

# Устанавливает Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливает и включает необходимые PHP-расширения
RUN docker-php-ext-install pdo pdo_mysql bcmath sockets

# Устанавливает рабочий каталог
WORKDIR /var/www

# Описывает открытый порт внутри контейнера
EXPOSE 9000
