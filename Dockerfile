FROM ubuntu:jammy

ARG DEBIAN_FRONTEND=noninteractive

ENV NODE_VERSION=18.20.3
ENV NVM_DIR=/root/.nvm
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"

USER root

RUN apt update -y
RUN apt upgrade -y

RUN apt install apache2 -y

RUN apt install php -y
RUN a2enmod rewrite
RUN a2enmod php8.1

RUN apt install php-bcmath php-json php-mbstring php-tokenizer php-xml php-curl php-gd php-intl php-zip php-mysql -y

RUN apt install imagemagick php-imagick -y

RUN apt install composer -y

RUN apt install curl -y
RUN curl https://raw.githubusercontent.com/creationix/nvm/master/install.sh | bash
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}

WORKDIR /var/www/html

RUN rm -rf ./*

COPY . .

RUN composer update

RUN npm install
RUN npm run build

RUN chown -R www-data:www-data bootstrap/cache
RUN chmod -R 775 bootstrap/cache

RUN php artisan storage:link

RUN chown -R www-data:www-data storage
RUN chmod -R 775 storage

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN chmod +x write_apache_config.sh
RUN . ./write_apache_config.sh

EXPOSE 80

RUN php artisan optimize

RUN service apache2 restart

CMD ["apache2ctl", "-D", "FOREGROUND"]