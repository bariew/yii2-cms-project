<?php
/**
 * Application configuration shared by all test types
 */
return \yii\helpers\ArrayHelper::merge([
    'language' => 'en-US',
    'bootstrap' => [],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
            'fixtureDataPath' => '@tests/codeception/fixtures',
            'templatePath' => '@tests/codeception/templates',
            'namespace' => 'tests\codeception\fixtures',
        ],
    ],
    'components' => [
        'language' => 'en',
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=campman_test',
            'username' => '',
            'password' => '',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'log' => [],
    ],
    'params' => [
        'baseUrl' => 'http://localhost:8080',
        'auth' => [
            'username' => 'admin',
            'password' => 'admin',
        ],
    ]
], (file_exists(__DIR__ . '/config-local.php') ? (require __DIR__ . '/config-local.php') : []));
