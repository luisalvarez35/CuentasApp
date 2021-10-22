# PHP + Apache
FROM phpstorm/php-apache:8.0-xdebug3.0

# Update OS and install common dev tools
RUN apt-get update
RUN apt-get install -y nano zip libzip-dev

# Install PHP extensions needed
RUN docker-php-ext-install -j$(nproc) mysqli pdo_mysql zip

# Instala composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Set working directory to web files
WORKDIR /var/www/html