# Versions 3.8 and 3.7 are current stable supported versions.
FROM alpine:3.9

# trust this project public key to trust the packages.
ADD https://dl.bintray.com/php-alpine/key/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub

## you may join the multiple run lines here to make it a single layer

# make sure you can use HTTPS.
RUN apk --update add ca-certificates

# add the repository, make sure you replace the correct versions if you want.
RUN apk add --update curl ca-certificates
RUN curl https://dl.bintray.com/php-alpine/key/php-alpine.rsa.pub -o /etc/apk/keys/php-alpine.rsa.pub
RUN echo "@php https://dl.bintray.com/php-alpine/v3.9/php-7.3" >> /etc/apk/repositories

# update php base.
RUN apk add --update php-common@php

# install php and some extensions.
RUN apk add --update php@php
RUN apk add --update php-mbstring@php
RUN apk add --update php-json@php
RUN apk add --update php-curl@php
RUN apk add --update php-zip@php
RUN apk add --update php-iconv@php
RUN apk add --update php-zlib@php
RUN apk add --update php-phar@php
RUN apk add --update php-openssl@php
RUN apk add --update php-session@php

# install php composer package manager.
RUN apk add --update composer

# add global php binding.
RUN ["ln", "-s", "/usr/bin/php7", "/usr/bin/php"]

# install prestissimo for high speed composer package download.
RUN ["composer", "global", "require", "hirak/prestissimo"]

# copy composer.json file.
COPY composer.json composer.json

# run composer installation.
RUN ["composer", "install"]

# install roadrunner binary.
RUN ["./vendor/bin/rr", "get-binary"]

# copy worker file.
COPY worker.php worker.php

# copy roadrunner yaml file.
COPY .rr.yaml .rr.yaml

COPY app app

# run server
CMD ["./rr", "serve", "-v", "-d"]

#expose port
EXPOSE 8080
