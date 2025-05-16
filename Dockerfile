FROM richarvey/nginx-php-fpm:3.1.6

# Cài Node.js & npm
USER root
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get update && \
    apt-get install -y nodejs && \
    npm install -g npm

# Copy toàn bộ source vào container
COPY . .

# Laravel image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Cho phép Composer chạy bằng root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Cài frontend và build Vite
RUN cd /var/www/html && \
    npm install && \
    npm run build

# CMD khởi chạy container
CMD ["/start.sh"]
