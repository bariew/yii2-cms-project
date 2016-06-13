<?php return \yii\helpers\ArrayHelper::merge([
    'id' => 'app',
    'name'  => 'NullCMS',
    'language'  => 'ru',
    'timeZone' => 'Europe/Moscow',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'db' => [
            'class' => '\\yii\\db\\Connection',
            'dsn' => 'mysql:host=localhost;dbname=nullcms',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'enableSchemaCache' => '1',
            'schemaCacheDuration' => '3600',
        ],
        'user' => [
            'identityClass' => 'bariew\\userModule\\models\\User',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\GoogleOAuth',
                    'clientId' => '',
                    'clientSecret' => '',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '',
                    'clientSecret' => '',
                ],
            ],
        ],
        'i18n'  => [
            //'class' => 'bariew\i18nModule\components\I18N',
            'translations' => [
                'modules/*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                ],
                'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl'       => true,
            'showScriptName'        => false,
            'enableStrictParsing'   => true,
            'rules' => [
                '/' => 'page/default/view',
                '<controller>/<action>' => '<controller>/<action>',
                '<module>/<controller>/<action>' => '<module>/<controller>/<action>',
                '<url:\\S+>' => 'page/default/view',
            ],
        ],
        'event' => [
            'class'  => 'bariew\eventManager\EventManager',
            'events' => [
                'yii\web\Controller' => [
                    'beforeAction' => [
                        //['bariew\rbacModule\components\EventHandlers', 'beforeActionAccess']
                    ]
                ],
                'yii\web\Response' => [
                    'afterPrepare' => [
                        //['bariew\rbacModule\components\EventHandlers', 'responseAfterPrepare']
                    ]
                ],

            ]
        ],
        'request'   => [
            'cookieValidationKey'   => 'someValidationKey'
        ],
        'authManager'   => [
            'class' => '\yii\rbac\DbManager',
            'cache' => 'yii\caching\FileCache',
            'defaultRoles' => [
                'site/error', 'page/default/view', 'user/default/logout',
                'user/default/login', 'user/default/register', 'user/default/auth',
                'user/default/confirm'
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.gmail.com',
//                'username' => 'xxxxxx',
//                'password' => 'xxxxx',
//                'port' => '465',
//                'encryption' => 'ssl',
//            ],
        ],
        'log' => [
            'traceLevel' => 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'fileMode' => 0777,
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:404',
                        'yii\i18n\PhpMessageSource::loadMessages'
                    ],
                ],
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/web/themes/null',
                    '@app/modules' => '@app/web/themes/null/modules',
                ],
                'basePath' => '@app/web/themes/null',
                'baseUrl' => '@web/themes/null',
            ],
        ],
        'formatter' => [
            'dateFormat' => 'php:Y-m-d',
            'timeFormat' => 'php:H:i',
            'datetimeFormat' => 'php:Y-m-d H:i',
        ],
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true,
        ],
    ],
    'modules' => [
        'page' => ['class' => 'bariew\\pageModule\\Module'],
        'user' => ['class' => 'bariew\\userModule\\Module'],
        'i18n' => ['class' => 'bariew\\i18nModule\\Module'],
        'rbac' => ['class' => 'bariew\\rbacModule\\Module'],
    ],
    'params'    => [
        'baseUrl' => 'mysite.com',
        'adminEmail'    => 'your.email@site.com'
    ]
], require __DIR__ . DIRECTORY_SEPARATOR . 'local.php');