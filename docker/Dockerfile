FROM php:5.6-cli-jessie

## Add composer and phpunit
RUN apt update && \
    apt install -y git zip unzip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    curl -O -L https://phar.phpunit.de/phpunit-5.7.phar && \
    chmod +x phpunit-5.7.phar && \
    mv phpunit-5.7.phar /usr/local/bin/phpunit && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug

ENTRYPOINT bash
