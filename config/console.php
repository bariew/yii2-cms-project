<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
$localConfigPath = __DIR__ . '/local.php';
$localConfig = file_exists($localConfigPath)
    ? require $localConfigPath : [];

return \yii\helpers\ArrayHelper::merge([
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
    ],
], $localConfig);
