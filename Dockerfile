# Use the official PHP image as a base image
FROM php:8.1-apache

## Set the working directory in the container
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip


# Install the MySQL driver for PHP
RUN docker-php-ext-install pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Composer files
COPY composer.json composer.lock /var/www/html/

# Copy the rest of the application code
COPY . /var/www/html/

# Install project dependencies
RUN composer install

# Generate the application key
RUN php artisan key:generate

# Run database migrations and seed the database
RUN php artisan migrate --seed

# Install Node.js and NPM
RUN apt-get install -y nodejs npm

# Install NPM dependencies and compile assets
RUN npm install && npm run dev

# Expose port 80 for the Laravel application
EXPOSE 80

# Start the Laravel application
CMD ["apache2-foreground"]
