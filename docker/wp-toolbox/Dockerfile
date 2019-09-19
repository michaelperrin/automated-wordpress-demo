FROM php:7.3-cli-alpine

RUN apk add --no-cache curl
RUN apk add --no-cache make

# Install WP-CLI in the toolbox
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar
RUN mv wp-cli.phar /usr/local/bin/wp-cli

# Install MySQL extension, as WP-CLI needs to access to the WordPress database
RUN docker-php-ext-install mysqli

# Execute commands as www-data user instead of root
USER www-data

WORKDIR /wordpress

ENTRYPOINT [ "make", "-f", "/scripts/Makefile" ]
