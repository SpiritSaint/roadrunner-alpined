# RoadRunned

This project is a docker image for PHP powered apps using RoadRunner and Alpine Linux.

## Why

- **Ubuntu based images are heavy**, Using in very simple cases, Ubuntu uses up to 15 times more storage space. _This images only uses ~100Mb._
- **NGINX with FPM is slow**, offers superior performance than a mixed configuration using the PHP process manager combined with Nginx as a TCP gateway.

## Specifications

In the following table are included some specific details of this Docker image.

|Spec|Detail|
|---|---|
|PHP Version|This image uses the latest PHP 7.3 available from [Codecasts/PHP-Alpine](https://github.com/codecasts/php-alpine) repository.|
|Alpine Version|This image uses the 3.9 version.|

## Disclaimer

This repository is in WIP. 
