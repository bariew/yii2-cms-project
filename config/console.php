<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
$mainConfigPath = __DIR__ . '/web.php';
$mainConfig = file_exists($mainConfigPath) ? require $mainConfigPath : [];

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
        'db'    => $mainConfig['components']['db']
    ],
    'modules' => $mainConfig['modules'],
];
