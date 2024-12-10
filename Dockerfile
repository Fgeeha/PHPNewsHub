FROM php:8.2-apache

# Установите зависимости для Composer
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libpq-dev \
    postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql \ 
    && a2enmod rewrite

# Настройка рабочей директории в контейнере
WORKDIR /var/www/html

COPY ./src /var/www/html
# Настройка Apache
# RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf
# RUN sed -i 's|/var/www/html|/var/www/html/public|' /etc/apache2/sites-available/000-default.conf
# RUN a2enmod rewrite
# Открываем порт 80 для веб-сервера
EXPOSE 80

