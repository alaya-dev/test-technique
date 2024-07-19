FROM php:8.1-fpm

# Installer les dépendances
RUN apt-get update \
    && apt-get install -y git unzip libpq-dev libpng-dev libjpeg-dev libfreetype6-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer les dépendances Laravel
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --no-scripts --no-autoloader

# Copier les fichiers de l'application
COPY . .

# Générer la clé Laravel
RUN php artisan key:generate

# Exécuter les migrations et les seeds
#RUN php artisan migrate --seed

# Exposer le port et démarrer le serveur php-fpm
EXPOSE 9000
CMD ["php-fpm"]
