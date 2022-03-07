FROM php:7.4-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

COPY ./crontab /etc/crontabs/root

COPY ./wait-for-it.sh /
RUN chmod +x /wait-for-it.sh

CMD ["./wait-for-it.sh" , "web:8080" , "--strict" , "--timeout=300"]

WORKDIR /
