#!/bin/bash
set -e

docker compose run --rm php-fpm $@
