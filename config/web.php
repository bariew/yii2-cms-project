<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'Yii CMS',
    'language'  => 'en',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'extensions'=> require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => [
        'cms'   => [
            'class'         => 'bariew\cmsBootstrap\Cms',
        ],
        'urlManager' => [
            'enablePrettyUrl'       => true,
            'showScriptName'        => false,
            'enableStrictParsing'   => true,
            'rules' => [
                '<_a>'    => 'site/<_a>',
                '/'                 => 'site/index',
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/web/themes/default',
                    '@app/modules' => '@app/web/themes/default',
                ],
                'basePath' => '@app/web/themes/default',
                'baseUrl' => '@web/themes/default',
            ],
        ],
        'authManager'   => [
            'class' => '\yii\rbac\DbManager'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
