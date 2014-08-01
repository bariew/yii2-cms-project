<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
$localConfigPath = __DIR__ . '/local/main.php';
$localConfig = file_exists($localConfigPath) ? require $localConfigPath : [];

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'extensions'=> require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager'   => [
            'class' => '\yii\rbac\DbManager'
        ],
        'db'    => @$localConfig['components']['db']
    ],
];
