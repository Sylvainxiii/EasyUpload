#!/usr/bin/env bash

if [ ! -d "./var" ]; then
  mkdir -p "var/logs"
fi

if [ ! -f "./var/bdd.db" ]; then
  sqlite3 ./bdd.db <documents/schema.sql
fi

chmod -R o+w "./var"

chmod -R o+w "./uploads"

composer update
