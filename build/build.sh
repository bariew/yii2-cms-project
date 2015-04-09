#!/bin/bash

# build.sh - script for building commit.
# rm -rf "`composer config cache-dir`"

COMMAND=$1;
BRANCH=$2;

case "$COMMAND" in
    build)
        phing -f build/build.xml build
        ;;
    init)
        phing -f build/build.xml build -Dinit=true
        ;;
    initlocal)
        chmod 0777 web/assets
        chmod 0777 web/files
        chmod 0777 runtime
        chmod 0777 config/local
        chmod 0777 web/assets
        composer global require "fxp/composer-asset-plugin:1.0.*@dev"
        composer update
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
    delete)
        git branch -D $BRANCH
        git push origin :$BRANCH
        ;;
    update)
        composer self-update
        composer global update fxp/composer-asset-plugin
        composer install
        ./yii migrate --interactive=0
#        ./yii message console/config/i18n.php --interactive=0
        ;;
#    test)
#        ./yii/vendor/bin/codecept run functional --config yii/tests/codeception/backend/codeception.yml
#        ./yii/vendor/bin/codecept run functional --config yii/tests/codeception/frontend/codeception.yml
#        ./yii/vendor/bin/codecept run functional --config yii/tests/codeception/api/codeception.yml
#        ;;
    *)
        echo "Available commands: update, delete, test, merge, build, init, initlocal"
        ;;
esac