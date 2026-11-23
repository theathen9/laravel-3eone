
# ============================================================
# 1. Frontend
# ============================================================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build


# ============================================================
# 2. Composer dependencies
# ============================================================
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN --mount=type=cache,target=/root/.composer/cache \
    composer install \
        --no-dev \
        --prefer-dist \
        --optimize-autoloader \
        --no-interaction \
        --no-progress \
        --no-scripts

COPY . .

RUN composer dump-autoload \
    --no-dev \
    --optimize


# ============================================================
# 3. PHP + Laravel
# ============================================================
FROM php:8.4-cli-bookworm AS app

ENV APP_ENV=production \
    APP_DEBUG=false

WORKDIR /var/www/html


# ============================================================
# System dependencies + PHP extensions
# ============================================================
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        unzip \
        zip \
        libpq-dev \
        libzip-dev \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libwebp-dev \
        $PHPIZE_DEPS \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        intl \
        opcache \
        pcntl \
        pdo_pgsql \
        pgsql \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get purge -y --auto-remove $PHPIZE_DEPS \
    && rm -rf /var/lib/apt/lists/*


# ============================================================
# Copy Laravel application
# ============================================================
COPY . .

COPY --from=vendor /app/vendor ./vendor

COPY --from=frontend /app/public/build ./public/build


# ============================================================
# Validate PHP source encoding
# ============================================================
RUN php -r '\
$files = new RecursiveIteratorIterator(\
    new RecursiveDirectoryIterator("config", FilesystemIterator::SKIP_DOTS)\
);\
foreach ($files as $file) {\
    if (!$file->isFile() || $file->getExtension() !== "php") continue;\
    $handle = fopen($file->getPathname(), "rb");\
    $bom = fread($handle, 3);\
    fclose($handle);\
    if ($bom === "\xEF\xBB\xBF") {\
        fwrite(STDERR, "UTF-8 BOM detected: ".$file->getPathname().PHP_EOL);\
        exit(1);\
    }\
}\
'


# ============================================================
# Laravel permissions
# ============================================================
RUN mkdir -p \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache


# ============================================================
# Laravel package discovery
# ============================================================
RUN php artisan package:discover --ansi


# ============================================================
# Production configuration
# ============================================================
RUN php artisan view:cache


# ============================================================
# Laravel HTTP Server
# ============================================================
EXPOSE 80

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
