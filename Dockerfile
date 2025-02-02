FROM php:8.2-fpm

# Sistem paketlerini yükleme
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    netcat-traditional

# PHP eklentilerini yükleme
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer'ı yükleme
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Çalışma dizinini ayarlama
WORKDIR /var/www

# Proje dosyalarını kopyala
COPY . .

# Composer bağımlılıklarını yükle
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Storage ve cache dizinlerine yazma izni ver
RUN chmod -R 775 storage bootstrap/cache

# Copy entrypoint script ve izinleri ayarla
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Kullanıcı haklarını ayarlama
RUN chown -R www-data:www-data .

# Kullanıcıyı değiştir
USER www-data

RUN php artisan key:generate

# Set entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
