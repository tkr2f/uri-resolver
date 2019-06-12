#!/bin/sh

set -e

# check parameter
if [[ -z ${1} ]]; then
  echo "#0 parameter of composer command is not found." >&2
  exit 1
fi

set -eu

docker run --rm --interactive --tty \
  --volume $PWD:/app \
  -u $(id -u):$(id -g) \
  composer ${1}
