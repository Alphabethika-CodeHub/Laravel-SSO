FROM php:8.2.14-fpm-alpine

# Install PHP With Extension & Composer
RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Install Dependencies & Setup Laravel
RUN composer install
RUN cp .env.example .env
RUN php artisan key:generate
RUN php artisan migrate
RUN php artisan passport:install --force

# Install Node JS
RUN apk add --update nodejs npm
RUN npm rebuild node-sass
RUN npm install