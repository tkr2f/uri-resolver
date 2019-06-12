#!/bin/sh

docker run \
  --volume $PWD:/app \
  -u $(id -u):$(id -g) \
  php:7.3.6-cli-alpine3.9 /app/script/phpunit.sh
