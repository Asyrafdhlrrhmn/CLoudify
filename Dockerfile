# FROM php:8.2-apache

# # Install extensions
# RUN docker-php-ext-install mysqli pdo pdo_mysql

# # Enable rewrite (aman, tidak bentrok MPM)
# RUN a2enmod rewrite

# # Copy app
# COPY . /var/www/html/

# # Set Apache to listen on Railway's PORT
# ENV PORT=8080
# RUN sed -i "s/Listen 80/Listen 8080/" /etc/apache2/ports.conf

# EXPOSE 8080

# CMD ["apache2-foreground"]
FROM php:8.2-apache

# Install extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable rewrite
RUN a2enmod rewrite

# --- START OF FIX: Menonaktifkan MPM Berlebih ---
# Image 'php:*-apache' menggunakan mpm_prefork secara default.
# Nonaktifkan mpm_event dan mpm_worker untuk menghindari galat "More than one MPM loaded".
RUN a2dismod mpm_event && \
    a2dismod mpm_worker
# --- END OF FIX ---

# Copy app
COPY . /var/www/html/

# Set Apache to listen on Railway's PORT
ENV PORT=8080
RUN sed -i "s/Listen 80/Listen 8080/" /etc/apache2/ports.conf

EXPOSE 8080

CMD ["apache2-foreground"]