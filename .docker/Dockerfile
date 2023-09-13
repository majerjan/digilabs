FROM ubuntu:23.04
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN apt update --fix-missing

#php
RUN apt install php8.1 -y
RUN apt install php-xml -y
RUN apt install php-mbstring -y
RUN apt install zip unzip php8.1-zip -y
RUN apt install php8.1-curl -y
RUN apt install php8.1-gd -y

COPY ./apache2.conf /etc/apache2/apache2.conf
RUN a2enmod rewrite

ENTRYPOINT ["sh", ".docker/entrypoint.sh"]