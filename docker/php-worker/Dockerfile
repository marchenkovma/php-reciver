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
    libicu-dev \
    supervisor

# Устанавливает и включает необходимые PHP-расширения
RUN docker-php-ext-install pdo pdo_mysql bcmath intl sockets

# Устанавливает рабочий каталог
#WORKDIR /var/www

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
