FROM alpine:3.5
MAINTAINER Arvind Rawat <arvindr226@gmail.com>

#RUN ln -s /usr/bin/php5 /usr/bin/php
RUN curl -sS https://getcomposer.org/installer | php5 -- --install-dir=/usr/bin --filename=composer

RUN  rm -rf /var/cache/apk/*

# AllowOverride ALL
RUN sed -i '264s#AllowOverride None#AllowOverride All#' /etc/apache2/httpd.conf
#Rewrite Moduble Enable
RUN sed -i 's#\#LoadModule rewrite_module modules/mod_rewrite.so#LoadModule rewrite_module modules/mod_rewrite.so#' /etc/apache2/httpd.conf
# Document Root to /var/www/html/web
RUN sed -i 's#/var/www/html#/var/www/html/web#g' /etc/apache2/httpd.conf
#Start apache
RUN mkdir -p /run/apache2

RUN cd /var/www/html

CMD bash -c "composer install"

CMD /usr/sbin/apachectl  -D   FOREGROUND