FROM ubuntu:17.10

# Update dependences
RUN apt-get update

# Install AMP, php extensions, dependences
RUN apt-get install --no-install-recommends --no-install-suggests -y \
    apache2 \
    php7.1 \
    php7.1-mysql \
    libapache2-mod-php7.1 \
    php7.1-mbstring \
    php7.1-xml \
    php7.1-zip \
    php7.1-curl \
    php7.1-gd \
    curl \
    lynx-cur \
    composer \
    supervisor \
    nano

# Enable apache mods
RUN a2enmod php7.1
RUN a2enmod rewrite
