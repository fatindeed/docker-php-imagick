FROM php:alpine

ARG ALPINE_MIRROR

# Build-time metadata as defined at http://label-schema.org
ARG BUILD_DATE
ARG VCS_REF
ARG VERSION
LABEL maintainer="James Zhu <168262+fatindeed@users.noreply.github.com>" \
      org.label-schema.build-date=$BUILD_DATE \
      org.label-schema.name="php-imagick" \
      org.label-schema.description="Invisible mask demo" \
      org.label-schema.url="https://hub.docker.com/r/fatindeed/php-imagick/" \
      org.label-schema.vcs-ref=$VCS_REF \
      org.label-schema.vcs-url="https://github.com/fatindeed/docker-php-imagick" \
      org.label-schema.vendor="James Zhu" \
      org.label-schema.version=$VERSION \
      org.label-schema.schema-version="1.0"

ENV IMAGEMAGICK_URL="https://www.imagemagick.org/download/ImageMagick.tar.xz"

COPY www-data /home/www-data/

RUN set -xe; \
# Switch to a mirror if given
    if [ -n "$ALPINE_MIRROR" ]; then \
        ALPINE_MIRROR=${ALPINE_MIRROR//\//\\\/}; \
        sed -i "s/http:\/\/dl-cdn.alpinelinux.org/$ALPINE_MIRROR/g" /etc/apk/repositories; \
    fi; \
# Install build dependency packages
    apk update; \
    apk add --virtual .php-rundeps freetype libpng libjpeg-turbo libgcc libgomp fftw; \
    apk add --virtual .phpize-deps-configure $PHPIZE_DEPS freetype-dev libpng-dev libjpeg-turbo-dev fftw-dev; \
# imagick
    mkdir -p /usr/src/imagemagick; \
    curl -fsSL "$IMAGEMAGICK_URL" | tar -Jx -C /usr/src/imagemagick --strip-components=1; \
    cd /usr/src/imagemagick; \
    ./configure --enable-delegate-build --with-fft; \
    make; \
    make install; \
    ldconfig /usr/local/lib; \
    cd -; \
    rm -rf /usr/src/imagemagick; \
# Install PHP extensions
    pecl install imagick; \
    docker-php-ext-enable imagick; \
    docker-php-source delete; \
# Cleanup
    apk del .phpize-deps-configure; \
    rm -rf /tmp/pear; \
    rm -rf /usr/local/include; \
    rm -rf /var/cache/apk/*

WORKDIR /home/www-data

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80"]