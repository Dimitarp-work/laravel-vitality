# Use an official Node image for building assets
FROM node:18 AS node-build

WORKDIR /app

# Copy only package files first for better caching
COPY package.json package-lock.json ./

# Install dependencies (including tailwindcss, postcss, etc.)
RUN npm install

# Copy the rest of your application (for Vite to access source files)
COPY . .

# Build assets
RUN npm run build

# --- Laravel PHP image ---
FROM php:8.2-fpm

WORKDIR /var/www

# Install system dependencies, composer, etc. (add your own as needed)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Laravel app files
COPY . .

# Copy built assets from node-build stage
COPY --from=node-build /app/public/build ./public/build
COPY --from=node-build /app/node_modules ./node_modules

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions (adjust as needed)
RUN chown -R www-data:www-data /var/www

# Expose port and start
EXPOSE 9000
CMD ["php-fpm"]
