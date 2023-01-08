FROM php:8.1.1-apache

# Install dependencies
RUN apt update \
    # common libraries and extensions
    && apt install -y git acl openssl openssh-client zip \
    && apt install -y libpng-dev zlib1g-dev libzip-dev libxml2-dev libicu-dev \
    && docker-php-ext-install intl pdo zip \
    # for MySQL
    && docker-php-ext-install pdo_mysql \
    # APCu
    && pecl install apcu \
    # enable Docker extensions
    && docker-php-ext-enable --ini-name 05-opcache.ini opcache apcu

# Install and run composer
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

COPY ./composer.* /var/www/html/

RUN composer install --prefer-dist --no-scripts --no-interaction --no-dev

# Copy project content and execute necessary commands
COPY . /var/www/html/
RUN /var/www/html/bin/console a:i
RUN /var/www/html/bin/console lexik:jwt:generate-keypair --skip-if-exists

## Create var folder and assign to Apache user
RUN mkdir -p /var/www/html/var
RUN chown -R www-data:www-data /var/www/html/var

# Update Apache config
COPY ./docker/php-apache/default.conf /etc/apache2/sites-available/default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && a2enmod rewrite \
    && a2dissite 000-default \
    && a2ensite default \
    && service apache2 restart

# Setup PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

EXPOSE 80
