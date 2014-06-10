<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'Yii CMS',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'extensions'=> require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'modules'   => require __DIR__ . '/_modules.php',
    'components' => [
        'cms'   => [
            'class'         => 'bariew\cmsBootstrap\Cms',
        ],
        'urlManager' => [
            'enablePrettyUrl'       => true,
            'showScriptName'        => false,
            'enableStrictParsing'   => true,
            'rules' => require __DIR__ . '/_rules.php',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class'             => 'app\modules\user\models\WebUser',
            'enableAutoLogin'   => true,
        ],
        'errorHandler' => [
            'errorAction' => 'main/default/error',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class'=>'yii\debug\Module',
         'allowedIPs' => ['*']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
