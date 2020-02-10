#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U citas -d citas < $BASE_DIR/citas.sql
fi
psql -h localhost -U citas -d citas_test < $BASE_DIR/citas.sql
