FROM php:8.2-apache

# Install MySQLi & PDO MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable mod_rewrite
RUN a2enmod rewrite

# Copy project ke Apache root
COPY . /var/www/html/

# Railway PORT
ENV PORT=8080
EXPOSE 8080

CMD ["apache2-foreground"]