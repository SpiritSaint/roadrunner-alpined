# RoadRunned

This project is a docker image for Laravel and PHP powered apps using RoadRunner and Alpine Linux.

## Why

- **Ubuntu based images are heavy**, Using in very simple cases, Ubuntu uses up to 15 times more storage space. _This images only uses ~100Mb._
- **NGINX with FPM is slow**, offers superior performance than a mixed configuration using the PHP process manager combined with Nginx as a TCP gateway.

## Specifications

In the following table are included some specific details of this Docker image.

|Spec|Detail|
|---|---|
|PHP Version|This image uses the latest PHP 7.3 available from [Codecasts/PHP-Alpine](https://github.com/codecasts/php-alpine) repository.|
|Alpine Version|This image uses the 3.9 version.|

Currently this image includes some PHP libraries likes:

- mbstring
- json
- curl
- zip
- zlib
- phar
- openssl
- iconv
- session

Also include prestissimo for fast composer packages download.

## Settings

This repository can be configured to better respond to the specific needs of the use case:

### Roadrunner options

Roadrunner has a repository with documentation of the process manager, locally there exists some files for specific configs. 

- [Available options](https://github.com/spiral/roadrunner/blob/master/.rr.yaml) are located on [.rr.yaml](.rr.yaml).
- [Worker configuration](https://roadrunner.dev/docs/php-worker) are coded on [worker.php](worker.php).

### PHP Libraries

If you need add some PHP library, you should add that extension on Dockerfile. For example:

```dockerfile
# install php and some extensions. (LN:20)
RUN apk add --update php-iconv@php
```

Remember use `@php` to use latest PHP version. Otherwise the version can be downgraded by default.

## Deploying

### Laravel Application

Currently, this repository uses a fresh laravel application. To customize this image with your own application, you should drag and drop your app over `app` directory. Rebuild this image and have fun.

## Disclaimer

This repository is in WIP. 
