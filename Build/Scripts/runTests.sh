#!/usr/bin/env bash




# Go to the directory this script is located, so everything else is relative
# to this dir, no matter from where this script is called.
THIS_SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd )"
cd "$THIS_SCRIPT_DIR" || exit 1

# Go to directory that contains the local docker-compose.yml file
cd ../Docker || exit 1

export PHP=${PHP:-7.4}


# Move "7.4" to "php74", the latter is the docker container name
export DOCKER_PHP_IMAGE=`echo "php${PHP}" | sed -e 's/\.//'`
export ROOT_DIR=`readlink -f ${PWD}/../../`
export HOST_UID=`id -u`

docker-compose run "$@"
SUITE_EXIT_CODE=$?
docker-compose down
exit $SUITE_EXIT_CODE
