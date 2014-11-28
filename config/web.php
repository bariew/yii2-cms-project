<?php
$localConfigPath = __DIR__ . '/local/main.php';
$localConfig = file_exists($localConfigPath) ? require $localConfigPath : [];

$mainConfig = array_merge([
    'id' => 'app',
    'name'  => 'NullCMS',
    'language'  => 'en',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
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
            'password'  => 'root',
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
        'config' => ['class' => 'bariew\\configModule\\Module'],
        'module' => ['class' => 'bariew\\moduleModule\\Module'],
        'rbac'   => ['class' => 'bariew\\rbacModule\\Module'],
        'notice' => ['class' => 'bariew\\noticeModule\\Module'],
        'page'   => ['class' => 'bariew\\pageModule\\Module'],
        'user'   => ['class' => 'bariew\\userModule\\Module'],
        'i18n'   => ['class' => 'bariew\\i18nModule\\Module'],
        'event'  => ['class' => 'bariew\\eventModule\\Module'],
        'theme'  => ['class' => 'bariew\\themeModule\\Module'],
    ],
    'params'    => [
        'adminEmail'    => 'your.email@site.com'
    ]
], $localConfig);

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $mainConfig['bootstrap'][] = 'debug';
    $mainConfig['modules']['debug'] = [
        'class'=>'yii\debug\Module',
         'allowedIPs' => ['*']
    ];

    $mainConfig['bootstrap'][] = 'gii';
    $mainConfig['modules']['gii'] = 'yii\gii\Module';
}
$mainConfig['extensions'] = require(__DIR__ . '/../vendor/yiisoft/extensions.php');

return $mainConfig;
