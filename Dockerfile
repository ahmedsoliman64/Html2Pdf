FROM composer:1.9.3 as vendor

WORKDIR /tmp/

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist


FROM yiisoftware/yii2-php:5.6-apache

VOLUME ~/.composer-docker/cache:/root/.composer/cache:delegated
VOLUME ./:/app:delegated

COPY . /app
COPY --from=vendor /tmp/vendor/ /app/vendor/

RUN usermod -u 1000 www-data
RUN mkdir /app/runtime/cache
RUN chmod 777 /app/runtime -R

EXPOSE 80

# CMD bash -c  "php yii serve/index 127.0.0.1:80"