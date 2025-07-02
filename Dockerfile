FROM php:8.2-apache

RUN a2enmod rewrite

RUN docker-php-ext-install pdo pdo_mysql

ENV APACHE_DOCUMENT_ROOT=/var/www/html/

RUN sed -i "s|/var/www/html|${APACHE_DOCUMENT_ROOT}|g" /etc/apache2/sites-available/000-default.conf

# Set working directory
WORKDIR /var/www/html

# Copy everything from build context (src/) into container
COPY src/ /var/www/html

# Permissions (optional)
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
