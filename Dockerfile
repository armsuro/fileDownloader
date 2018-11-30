FROM alpine:3.6
LABEL Maintainer="Suren Gasparyan <suren.gasparyan1997@gmail.com>" \
      Description="Lightweight container with Nginx 1.12 & PHP-FPM 7.1 based on Alpine Linux."

# Install packages
RUN apk --no-cache add curl php7-fpm php7-json php7-curl php7-mbstring php7-mysqli php7-pdo php7-pdo_mysql \
    nginx supervisor

# Configure nginx
COPY ./docker.config/nginx.conf /etc/nginx/nginx.conf

# Configure php
#COPY ./docker.config/php.ini /etc/php7/php.ini

# Configure supervisord
COPY ./docker.config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Add application
RUN mkdir -p /var/www/html
WORKDIR /var/www/html
COPY ./ /var/www/html/

EXPOSE 80 443

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
