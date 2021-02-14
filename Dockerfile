FROM bebeco/docker-php-fpm-with-extensions:7.4

RUN mkdir -p /var/www/bebeco-api

WORKDIR /var/www/bebeco-api

RUN curl -sS https://getcomposer.org/installer | php
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv composer.phar /usr/local/bin/composer

COPY composer.json /var/www/bebeco-api
COPY composer.lock /var/www/bebeco-api

RUN composer install --no-autoloader --no-scripts --prefer-dist --no-autoloader --no-progress --no-suggest
RUN mkdir -p /var/www/bebeco-api/boot

COPY boot/Kernel.php /var/www/bebeco-api/boot
COPY boot/Cache.php /var/www/bebeco-api/boot
COPY etc /var/www/bebeco-api/etc
COPY bin /var/www/bebeco-api/bin

RUN mkdir -p var/cache
RUN mkdir -p var/logs
RUN mkdir -p var/sessions

RUN mkdir -p src
COPY src src

RUN mkdir -p \
 public \
 public/images/avatars \
 public/images/background \
 public/attachments

COPY . /var/www/bebeco-api/

RUN rm -fr etc/parameters.yml
RUN composer install && \
    composer dump-autoload --optimize --classmap-authoritative

RUN find var -exec chown www-data: {} +

CMD ["bash", "start.sh"]
