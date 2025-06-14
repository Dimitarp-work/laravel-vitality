FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip libpng-dev libonig-dev libxml2-dev \
    libzip-dev libpq-dev \
    nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Set working directory
WORKDIR /var/www

# Copy application code
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Install PHP dependencies (Laravel)
RUN composer install --no-dev --optimize-autoloader

# Install Node.js dependencies
RUN npm install

# Build frontend (Tailwind, Vite, etc.)
RUN npm run build

# Set permissions (optional, depending on your setup)
RUN chmod -R 775 storage bootstrap/cache

# Expose port for Laravel dev server
EXPOSE 8080

# Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
