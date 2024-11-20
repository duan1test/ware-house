FROM php:8.1-fpm

# Copy composer.lock and composer.json into the working directory
COPY composer.lock composer.json /var/www/html/cs-warehouse/

# Set working directory
WORKDIR /var/www/html/cs-warehouse/

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libxml2-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libmcrypt-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    nano \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    curl \
    gnupg2 \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Config supervisor
RUN mkdir -p "/var/log/supervisor"
COPY ./deploy/supervisord.conf /etc/supervisor/supervisord.conf

# Install extensions for php
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl xml bcmath
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Copy existing application directory contents to the working directory
COPY . /var/www/html/cs-warehouse
ADD ./deploy/custom_php.ini /usr/local/etc/php/conf.d/custom_php.ini

# Assign permissions of the working directory to the www-data user
RUN chown -R www-data:www-data \
        /var/www/html/cs-warehouse/storage \
        /var/www/html/cs-warehouse/bootstrap/cache
RUN chmod -R 777 /var/www/html/cs-warehouse/storage

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 9000
CMD ["php-fpm"]
CMD ["/usr/bin/supervisord"]
