# Usa la imagen base de PHP con Apache
FROM php:7.4-apache

# Instala extensiones PHP necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia los archivos de la aplicación al contenedor
COPY . /var/www/html

# Configura el puerto de escucha de Apache
EXPOSE 80

# Inicia Apache al arrancar el contenedor
CMD ["apache2-foreground"]
