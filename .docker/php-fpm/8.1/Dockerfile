FROM centos:7

RUN yum update -y && \
    yum install -y epel-release

RUN yum install -y http://rpms.remirepo.net/enterprise/remi-release-7.rpm && \
    yum install -y yum-utils && \
    yum-config-manager --enable remi-php81 && \
    yum -y update

RUN yum install -y php-fpm php-xml php-imap php-cli php-bcmath php-dba php-gd php-intl php-mbstring php-mysql php-pdo php-soap php-pecl-apcu php-opcache php-pecl-imagick php-zip php-sodium

RUN useradd -M -d /opt/app -s /bin/false nginx

RUN mkdir -p /run/php-fpm && \
    chown nginx:nginx /run/php-fpm

RUN mkdir -p /var/lib/php/session && \
    chown nginx:nginx /var/lib/php/session

COPY ./.docker/php-fpm/8.1/php-fpm.conf /etc/php-fpm.conf
COPY ./.docker/php-fpm/8.1/www.conf /etc/php-fpm.d/www.conf
COPY ./.docker/php-fpm/8.1/php.ini /etc/php.ini

RUN curl -sS https://getcomposer.org/installer | php
RUN mv /composer.phar /usr/local/bin/composer

RUN yum install -y zip unzip

RUN curl --silent --location https://rpm.nodesource.com/setup_16.x | bash -

RUN yum install -y nodejs git

RUN	yum -y update \
	&& yum --setopt=tsflags=nodocs -y install \
	mysql \
	&& rm -rf /var/cache/yum/* \
	&& yum clean all

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.rpm.sh' | bash

RUN yum install -y symfony-cli

RUN yum clean all

CMD php-fpm
