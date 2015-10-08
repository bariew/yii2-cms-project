#!/bin/bash

# build.sh - script for building commit.
# rm -rf "`composer config cache-dir`"

COMMAND=$1;
BRANCH=$2;
DIR=$( cd "$( dirname $0 )/../" && pwd );
cd $DIR;
case "$COMMAND" in
    create)
        phing -f build/build.xml build -Dinit=true
        ;;
    build)
        phing -f build/build.xml build
        ;;
    init)
        cp config/web-local.php.example config/web-local.php
        chmod 0777 web/assets
        chmod 0777 web/files
        chmod 0777 runtime
        chmod 0777 web/assets
        chmod 0777 config/web-local.php
        php composer.phar global require "codeception/codeception=2.0.*"
        php composer.phar global require "codeception/specify=*"
        php composer.phar global require "codeception/verify=*"
        php composer.phar global require "fxp/composer-asset-plugin:dev-master"
        php composer.phar update  --no-interaction
        ln -s ~/.composer/vendor/bin/codecept /usr/local/bin/codecept
        ln -s ~/.composer/vendor/codeception $DIR/vendor/codeception
        ;;
    merge)
        git checkout master
        git fetch
        git reset --hard origin/master
        git checkout $BRANCH
        git rebase master
        git checkout master
        git merge --no-ff $BRANCH -m "$BRANCH merge"
        git push
        git checkout $BRANCH
        ;;
    update)
        ./yii console/backup
        php composer.phar self-update
        php composer.phar global require "fxp/composer-asset-plugin:1.0.*@dev"
        php composer.phar install
        ./yii migrate --interactive=0
        rm -rf runtime/cache/*
        ./yii message config/i18n.php --interactive=0 > /dev/null
        ;;
    test)
        # Turn off debugger and set server config for index-test.php
        php -S localhost:8080 -t web & PID=$!
        rm -rf runtime/cache/*
        ./tests/codeception/bin/yii migrate --interactive=0
        ./tests/codeception/bin/yii console/generate --interactive=0
        codecept run $BRANCH --config tests/codeception.yml
        kill -9 $PID
        ;;
    *)
        echo "Available commands: create, build, update, test, merge, init"
        ;;
esac