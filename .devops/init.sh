#!/usr/bin/env bash

if [ ! -f "./storage/bdd.db" ]; then
  sqlite3 ./storage/bdd.db <documents/schema.sql
fi

chmod -R o+w "./storage"

composer update
