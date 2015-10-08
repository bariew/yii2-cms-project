<?php
$mainConfig = require __DIR__ . DIRECTORY_SEPARATOR . 'web.php';
return [
    'id' => 'console',
    'bootstrap' => [],
    'name'  => $mainConfig['name'],
    'language'  => $mainConfig['language'],
    'timeZone' => $mainConfig['timeZone'],
    'basePath' => dirname(__DIR__),
    'extensions'=> require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => [
        'db'            => $mainConfig['components']['db'],
        'cache'         => $mainConfig['components']['cache'],
        'authManager'   => $mainConfig['components']['authManager'],
        'i18n'          => $mainConfig['components']['i18n'],
        'event'         => $mainConfig['components']['event'],
        'log'           => [],
    ],
    'controllerMap' => [
        'migrate'   => 'bariew\moduleMigration\ModuleMigrateController',
    ],
    'modules' => $mainConfig['modules'],
    'params' =>  $mainConfig['params'],
];
