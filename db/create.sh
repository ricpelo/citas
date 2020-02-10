#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE citas_test;"
    psql -U postgres -c "CREATE USER citas PASSWORD 'citas' SUPERUSER;"
else
    sudo -u postgres dropdb --if-exists citas
    sudo -u postgres dropdb --if-exists citas_test
    sudo -u postgres dropuser --if-exists citas
    sudo -u postgres psql -c "CREATE USER citas PASSWORD 'citas' SUPERUSER;"
    sudo -u postgres createdb -O citas citas
    sudo -u postgres psql -d citas -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O citas citas_test
    sudo -u postgres psql -d citas_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    LINE="localhost:5432:*:citas:citas"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
