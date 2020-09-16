FROM php:7.4-fpm AS prod

FROM prod AS dev

#Tools
RUN apt-get -y update && \
    apt-get -y upgrade && \
    apt-get -y autoremove && \
    apt-get install -y wget gnupg git

#xDebug
RUN pecl install xdebug-2.9.6 && \
    docker-php-ext-enable xdebug

#Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '795f976fe0ebd8b75f26a6dd68f78fd3453ce79f32ecb33e7fd087d39bfeb978342fb73ac986cd4f54edd0dc902601dc') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

#Phive
RUN wget -O phive.phar https://phar.io/releases/phive.phar && \
    wget -O phive.phar.asc https://phar.io/releases/phive.phar.asc && \
    gpg --keyserver pool.sks-keyservers.net --recv-keys 0x9D8A98B29B2D5D79 && \
    gpg --verify phive.phar.asc phive.phar && \
    chmod +x phive.phar && \
    mv phive.phar /usr/local/bin/phive

#PHP Static Analysis Tools
RUN phive --no-progress install --global \
    --trust-gpg-keys C5095986493B4AA0,CF1A108D0E7AE720,4AA394086372C20A,0F9684B8B16B7AB0,31C7E470E2138192,76835C9464877BDD  \
    infection phpstan phpcpd phpmd phpcs dephpend
