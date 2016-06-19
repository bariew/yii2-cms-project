<?php
$mainConfig = require(__DIR__ . DIRECTORY_SEPARATOR . 'web.php');
unset(
    $mainConfig['bootstrap'],
    $mainConfig['components']['cache'],
    $mainConfig['components']['user'],
    $mainConfig['components']['errorHandler'],
    $mainConfig['components']['request']
);
return \yii\helpers\ArrayHelper::merge($mainConfig, array(
    'id' => 'console',
    'bootstrap'=>array('log'),
    'components'=>array(
        'urlManager' => [
            'baseUrl' => $mainConfig['params']['baseUrl'],
            'hostInfo' => $mainConfig['params']['baseUrl'],
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ]
    ),
    'controllerMap' => [
        //./yii clone/module @bariew/postModule @app/modules/product --replace=1 --inherit=1
        'clone' => 'bariew\yii2Tools\controllers\CloneController',
        'migrate'   => 'bariew\moduleMigration\ModuleMigrateController',
        'db' => 'dizews\dbConsole\DbController',
    ],
));