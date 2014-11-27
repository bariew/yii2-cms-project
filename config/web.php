<?php

$localConfigPath = __DIR__ . '/local/main.php';
$localConfig = file_exists($localConfigPath) ? require $localConfigPath : [];

$config = \yii\helpers\ArrayHelper::merge([
    'id' => 'app',
    'name'  => 'NullCMS',
    'language'  => 'en',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'extensions'=> require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => [
        'i18n'  => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl'       => true,
            'showScriptName'        => false,
            'enableStrictParsing'   => true,
            'rules' => [
                '<_a>'    => 'site/<_a>',
                '<_c>/<_a>'=>'<_c>/<_a>',
                '<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>',
                '/'                 => 'site/index',
            ],
        ],
        'request'   => [
            'cookieValidationKey'   => 'someValidationKey'
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
        'db'    => [
            'class' => '\yii\db\Connection',
            'dsn'   => 'mysql:host=localhost;dbname=nullcms',
            'username' => 'root',
            'password'  => '',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/web/themes/null',
                    '@app/modules' => '@app/web/themes/null',
                ],
                'basePath' => '@app/web/themes/null',
                'baseUrl' => '@web/themes/null',
            ],
        ],
    ],
    'modules' => [
        'config' => 'bariew\configModule\Module',
        'module' => 'bariew\moduleModule\Module'
    ],
    'params'    => [
        'adminEmail'    => 'your.email@site.com'
    ]
], $localConfig);

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
