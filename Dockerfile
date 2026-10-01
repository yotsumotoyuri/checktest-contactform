FROM php:8.2-apache

# Laravelに必要なPHPの拡張機能と、Composerをインストール
RUN apt-get update && apt-get install -y unzip git libzip-dev \
    && docker-php-ext-install zip
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ⚠️ Renderの仕様に合わせて、Apacheのポートを80番から10000番に変更 ⚠️
RUN sed -i 's/Listen 80/Listen 10000/g' /etc/apache2/ports.conf
RUN sed -i 's/<VirtualHost \*:80>/<VirtualHost \*:10000>/g' /etc/apache2/sites-available/*.conf

# Apacheの公開フォルダを Laravelの public に変更
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Laravelの動作に必要な設定（mod_rewriteの有効化）
RUN a2enmod rewrite

# ファイルをサーバーにコピー
COPY . /var/www/html/

# サーバー内で「vendor」フォルダを生成
RUN composer install --no-dev --optimize-autoloader --no-interaction

# フォルダの権限（パーミッション）を設定
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# ⚠️ Render用のポート番号を明示 ⚠️
EXPOSE 10000