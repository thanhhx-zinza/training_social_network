FROM composer:2 as vendor


WORKDIR /tmp/

COPY /composer.json composer.json
COPY /composer.lock composer.lock
COPY /database ./database
COPY /tests ./tests

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist


FROM gsviec/nginx-php:7.4
USER root
RUN apk add gettext libintl && mv /usr/bin/envsubst /usr/local/sbin/envsubst 
RUN set -ex \
	&& apk --no-cache add postgresql-libs postgresql-dev \
	&& docker-php-ext-install pgsql pdo_pgsql \
	&& apk del postgresql-dev
COPY docker/nginx-heroku.conf /etc/nginx/nginx.conf
COPY ./ /var/www/
COPY --from=vendor /tmp/vendor/ /var/www/vendor/
USER www-data
CMD /bin/bash -c "envsubst '\$PORT' < /etc/nginx/nginx.conf > /etc/nginx/nginx.conf" && supervisord -c '/etc/supervisor/conf.d/supervisord.conf'