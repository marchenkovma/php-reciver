# Устанавливает переменную среды
ARG NGINX_VERSION

# Устанавливает базовый образ NGINX с использованием переменной среды
FROM nginx:${NGINX_VERSION}

# Устанавливает переменные среды
ARG PHP_UPSTREAM_PORT
ARG PHP_UPSTREAM_CONTAINER

# Создает конфигурационный файл upstream.conf для проксирования запросов к PHP-серверу
# и удаляет стандартный конфигурационный файл default.conf
RUN echo "upstream php-upstream { server ${PHP_UPSTREAM_CONTAINER}:${PHP_UPSTREAM_PORT}; }" > /etc/nginx/conf.d/upstream.conf \
    && rm /etc/nginx/conf.d/default.conf

# Описывает открытый порт внутри контейнера
EXPOSE 80
