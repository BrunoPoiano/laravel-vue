FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    libpq-dev \
    netcat-traditional

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create directory and set permissions
RUN mkdir -p /var/www/html
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www

# Copy application files
COPY --chown=www-data:www-data . /var/www

# Set proper working directory for the application
WORKDIR /var/www

# Install dependencies
RUN composer install --no-scripts --no-autoloader
RUN npm install

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Set final permissions
RUN chmod -R 777 storage bootstrap/cache

# Create sessions table and run migrations
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 8000 5173

# Switch to non-root user
USER www-data

CMD ["/usr/local/bin/start.sh"]
