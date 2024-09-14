# 使用 PHP 8.2 的官方基礎映像
FROM php:8.2-fpm

# 安裝系統依賴
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libssl-dev \
    libmcrypt-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd mbstring zip pdo pdo_mysql

# 安裝 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 設置工作目錄
WORKDIR /var/www

# 複製現有應用程式代碼
COPY . .

# 授權存取權限
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# 安裝 Laravel 依賴
RUN composer install

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
