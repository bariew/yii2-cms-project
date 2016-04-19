#!/bin/bash

# build.sh - script for building commit.
# rm -rf "`composer config cache-dir`"

COMMAND=$1;
PARAM1=$2;
PARAM2=$3;
DIR=$( cd "$( dirname $0 )" && pwd );
cd $DIR;

case "$COMMAND" in
    build)
        SERVER="myserver"
        PATH="/var/www/mysite"
        case "$PARAM1" in
            stage)
                SERVER="stageserver"
                PATH="/var/www/mysite"
            ;;
            *)
                echo Building dev environment by default...
            ;;
        esac
        if [ -z "$PARAM2" ]
        then
            PARAM2="update"
        fi
        /usr/bin/rsync --recursive --links --compress --compress-level=9 --delete-after -e '/usr/bin/ssh -c arcfour -o Compression=no -x' --exclude-from=$DIR/.gitignore $DIR/ $SERVER:$PATH/
        /usr/bin/ssh $SERVER sh $PATH/build.sh $PARAM2 2>&1
        ;;
    init)
        cp config/local.php.example config/local.php
        chmod 0777 web/assets
        chmod 0777 web/files
        chmod 0777 runtime
        chmod 0777 web/assets
        chmod 0777 config/local.php
#        php composer.phar global require "codeception/codeception=2.0.*"
#        php composer.phar global require "codeception/specify=*"
#        php composer.phar global require "codeception/verify=*"
        php composer.phar global require "fxp/composer-asset-plugin"
#        php composer.phar update  --no-interaction
#        ln -s ~/.composer/vendor/bin/codecept /usr/local/bin/codecept
#        ln -s ~/.composer/vendor/codeception $DIR/vendor/codeception
        ;;
    merge)
        BRANCH=$( git rev-parse --abbrev-ref HEAD );
	    git add -A
        git commit -am "auto"
        git push -u origin $BRANCH
        git checkout master
        git fetch
        git reset --hard origin/master
        git merge --no-ff --no-edit $BRANCH
        git push
        ;;
    update)
        php composer.phar install
        ./yii migrate --interactive=0
        ./yii message config/i18n.php --interactive=0 > /dev/null
        rm -rf runtime/cache/*
        ;;
    test)
        # Turn off debugger and set server config for index-test.php
        php -S localhost:8080 -t web & PID=$!
        rm -rf runtime/cache/*
        ./tests/codeception/bin/yii migrate --interactive=0
        ./tests/codeception/bin/yii console/generate --interactive=0
        codecept run $PARAM1 $PARAM2 --config tests/codeception.yml
        kill -9 $PID
        ./yii console/sniff
        rm -rf runtime/cache/*
        ;;
    *)
        echo "Available commands: update, delete, test, merge, build, init, initlocal"
        ;;
esac