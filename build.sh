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
    merge)
        BRANCH=$( git rev-parse --abbrev-ref HEAD );
	    git add -A
        git commit -am "auto"
        git push -u origin $BRANCH
        git checkout $PARAM1
        git fetch
        git reset --hard origin/$PARAM1
        git merge --no-ff --no-edit $BRANCH
        git push
        git checkout -
        ;;
    update)
        chmod 0777 web/assets
        chmod -R 0777 web/files
        chmod 0777 runtime
        chmod +x yii
        cp --no-clobber config/local.php.example config/local.php
        php composer.phar install --no-dev --prefer-dist
        ./yii migrate --interactive=0
        #./yii message $APP/config/i18n.php
        rm -rf runtime/cache/*
        ;;
    dev)
        #php composer.phar update --prefer-source
        ./yii migrate --interactive=0
        ./yii message $APP/config/i18n.php
        rm -rf $APP/runtime/cache/*
        #find $APP/messages -type f -print0 | xargs -0 sed -i 's/@@//g'
        ;;
    test)
        # Turn off debugger and set server config for index-test.php
        php -S localhost:8080 -t web & PID=$!
        rm -rf runtime/cache/*
        ./tests/codeception/bin/yii migrate --interactive=0
        ./tests/codeception/bin/yii console/generate --interactive=0
        ~/.composer/vendor/codeception/codeception/codecept run $PARAM1 $PARAM2 --config $APP/tests/codeception.yml
        #kill -9 $PID
        #./yii console/sniff
        fuser -k 8080/tcp
        rm -rf runtime/cache/*
        ;;
    *)
        echo "Available commands: update, delete, test, merge, build"
        ;;
esac