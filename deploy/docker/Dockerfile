FROM ubuntu:18.04

RUN apt update -y
RUN apt upgrade -y
# Essentials
ENV DEBIAN_FRONTEND=noninteractive
ENV DEBCONF_NONINTERACTIVE_SEEN=true
RUN echo "Europe/Riga" > /etc/timezone
RUN apt update -y && apt  upgrade -y && apt install software-properties-common wget curl git vim wget systemd -y


# Supervisor
RUN apt install supervisor -y
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# PHP
RUN apt install php-cli php-fpm php php-gd php-mbstring php-xml php-pgsql php-zip -y php-mongodb
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN  php --version
RUN service php7.2-fpm stop
RUN mkdir -p /var/run/php

RUN sed -i '/^short_open_tag =/cshort_open_tag = On' /etc/php/7.2/cli/php.ini && \
sed -i '/^short_open_tag =/cshort_open_tag = On' /etc/php/7.2/fpm/php.ini && \
sed -i '/^error_reporting =/cerror_reporting = E_ALL & ~E_NOTICE & ~E_WARNING' /etc/php/7.2/fpm/php.ini && \
sed -i '/^error_reporting =/cerror_reporting = E_ALL & ~E_NOTICE & ~E_WARNING' /etc/php/7.2/cli/php.ini && \
sed -i '/^;daemonize =/cdaemonize = no' /etc/php/7.2/fpm/php-fpm.conf && \
sed -i '/^expose_php = On/cexpose_php = Off' /etc/php/7.2/fpm/php.ini && \
sed -i '/^upload_max_filesize =/cupload_max_filesize = 50M' /etc/php/7.2/cli/php.ini && \
sed -i '/^upload_max_filesize =/cupload_max_filesize = 50M' /etc/php/7.2/fpm/php.ini && \
sed -i '/^max_execution_time =/cmax_execution_time = 300' /etc/php/7.2/cli/php.ini && \
sed -i '/^max_execution_time =/cmax_execution_time = 300' /etc/php/7.2/fpm/php.ini


# NGINX

RUN apt install nginx -y
COPY nginx.conf /etc/nginx/nginx.conf
RUN rm /etc/nginx/sites-enabled/default

# Postgres
RUN wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add -
RUN add-apt-repository "deb http://apt.postgresql.org/pub/repos/apt/ bionic-pgdg main"

RUN apt update -y
RUN apt install postgresql-9.6 -y
COPY postgresql.conf /etc/postgresql/9.6/main/postgresql.conf
COPY pg_hba.conf /etc/postgresql/9.6/main/pg_hba.conf
RUN systemctl disable postgresql
# REDIS
RUN apt install redis-server redis-tools -y
COPY redis.conf /etc/redis.conf
RUN systemctl disable redis-server


# NODE
RUN apt install build-essential libpng-dev -y
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt install nodejs -y
RUN npm i -g npm
WORKDIR /var/www/app
CMD ["/usr/bin/supervisord"]
