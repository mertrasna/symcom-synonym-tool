FROM php:7.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libmcrypt-dev \
    libzip-dev \
    tzdata \
    && docker-php-ext-install mysqli pdo pdo_mysql zip mcrypt

# Clean up the apt cache to reduce image size
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set timezone to UTC (or your preferred timezone)
ENV TZ=UTC
RUN echo "date.timezone=$TZ" > /usr/local/etc/php/conf.d/timezone.ini

RUN curl -sS https://getcomposer.org/download/1.6.3/composer.phar -o /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer && \
    ln -s /usr/local/bin/composer /usr/bin/composer && \
    echo "Composer installed successfully"

# Ensure /usr/local/bin is in the PATH
ENV PATH="/usr/local/bin:$PATH"

# Verify Composer installation
RUN composer --version

# Set working directory
WORKDIR /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod rewrite
