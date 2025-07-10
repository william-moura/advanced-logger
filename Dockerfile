# Usar imagem oficial do PHP com Composer
FROM php:8.2-cli

# Instalar extensões PHP (pdo_mysql para logs em DB, etc.)
RUN docker-php-ext-install pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Diretório de trabalho
WORKDIR /var/www/html