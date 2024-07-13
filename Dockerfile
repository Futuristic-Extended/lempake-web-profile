# Base image
FROM ubuntu:jammy

# Environment variables and arguments
ARG DEBIAN_FRONTEND=noninteractive
ENV NODE_VERSION=18.20.3
ENV NVM_DIR=/root/.nvm
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"

# Install packages (consolidated for better layer caching)
RUN apt update -y && \
  apt upgrade -y && \
  apt install -y \
    apache2 \
    php \
    php-bcmath php-json php-mbstring php-tokenizer php-xml php-curl php-gd php-intl php-zip php-mysql \
    imagemagick php-imagick \
    composer \
    curl

# Install Node.js using NVM
RUN curl https://raw.githubusercontent.com/creationix/nvm/master/install.sh | bash && \
  . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION} && \
  . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION} && \
  . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}

# Set working directory
WORKDIR /var/www/html

# Clear out existing files
RUN rm -rf ./* 

# Copy project files
COPY . .

# Install project dependencies
RUN composer update && \
  npm install && \
  npm run build

# Apache configuration
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
  a2enmod rewrite php8.1
RUN chmod +x write_apache_config.sh && . ./write_apache_config.sh

# Permissions (consolidated)
RUN chown -R www-data:www-data bootstrap/cache storage && \
  chmod -R 775 bootstrap/cache storage && \
  php artisan storage:link

# Expose port and optimize
EXPOSE 80
RUN php artisan optimize

# Restart the Apache2
RUN service apache2 restart

# Start Apache (combined commands)
CMD ["apache2ctl", "-D", "FOREGROUND"]