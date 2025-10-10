FROM php:8.2-apache

RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    nodejs \
    curl \
    zip \
    unzip \
    pkg-config \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_sqlite bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

COPY . /var/www
RUN chown -R www-data:www-data /var/www

RUN mkdir -p /var/www/storage /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

RUN composer install --no-dev --optimize-autoloader
RUN npm ci && npm run build && rm -r node_modules

CMD ["apache2-foreground"]
