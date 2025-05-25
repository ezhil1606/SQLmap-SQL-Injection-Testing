FROM php:7.4-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Copy your app files to Apache root
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html

# Expose HTTP port
EXPOSE 80
