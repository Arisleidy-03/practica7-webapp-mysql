# Imagen base con PHP 8.2 y servidor Apache
FROM php:8.2-apache

# Extensiones necesarias para conectarse a MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copiar el código fuente de la aplicación
COPY src/ /var/www/html/

EXPOSE 80
