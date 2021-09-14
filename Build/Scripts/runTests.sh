#!/usr/bin/env bash

THIS_SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd )"
cd "$THIS_SCRIPT_DIR" || exit 1
cd ../Docker || exit 1

export PHP=${PHP:-7.4}
export DOCKER_PHP_IMAGE=`echo "php${PHP}" | sed -e 's/\.//'`
export ROOT_DIR=`readlink -f ${PWD}/../../`
export HOST_UID=`id -u`

SUITE=$1
ARGS="${@:2}"

case $SUITE in
    composer)
        docker-compose run composer $ARGS
    ;;
    unit)
        ARGS=${ARGS:-Tests/Unit/}
        docker-compose run unit -c .Build/vendor/nimut/testing-framework/res/Configuration/UnitTests.xml $ARGS
    ;;
    functional)
        ARGS=${ARGS:-Tests/Functional/}
        docker-compose run functional -c .Build/vendor/nimut/testing-framework/res/Configuration/FunctionalTests.xml $ARGS
    ;;
    *)
    echo "Invalid argument '$SUITE'"
    exit 1
    ;;
esac

SUITE_EXIT_CODE=$?
docker-compose down
exit $SUITE_EXIT_CODE
