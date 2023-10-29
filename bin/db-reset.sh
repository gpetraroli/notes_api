#!/bin/bash

echo 'Dropping db...'
php bin/console doctrine:database:drop --force

echo 'Creating db...'
php bin/console doctrine:database:create

echo 'Migrating...'
php bin/console --no-interaction doctrine:migration:migrate

echo 'Loading fixtures...'
php bin/console doctrine:fixtures:load --no-interaction --append
