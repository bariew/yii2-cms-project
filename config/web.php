<?php return \yii\helpers\ArrayHelper::merge([
    'id' => 'app',
    'name'  => 'NullCMS',
    'language'  => 'en',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [],
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
                '<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>',
                '/' => 'page/default/view',
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
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mail' => [
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
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
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
    ],
    'modules' => [
        'config' => ['class' => 'bariew\\configModule\\Module'],
        'module' => ['class' => 'bariew\\moduleModule\\Module'],
        'page' => ['class' => 'bariew\\pageModule\\Module'],
        'user' => ['class' => 'bariew\\userModule\\Module'],
        'i18n' => ['class' => 'bariew\\i18nModule\\Module'],
        'rbac' => ['class' => 'bariew\\rbacModule\\Module'],
        'notice' => ['class' => 'bariew\\noticeModule\\Module'],
    ],
    'params'    => [
        'adminEmail'    => 'your.email@site.com'
    ]
], (file_exists(__DIR__ . '/local/main.php') ? (require __DIR__ . '/local/main.php') : []));