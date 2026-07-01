#!/usr/bin/env bash

set -e

docker compose build
docker compose up -d

docker compose exec composer composer update

docker compose exec apache bash -c 'if [ ! -f "./storage/bdd.db" ]; then
  sqlite3 ./storage/bdd.db <documents/schema.sql
  chmod -R o+w "./storage"
fi'
