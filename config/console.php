<?php
$mainConfig = file_exists(__DIR__ . '/web.php') ? require __DIR__ . '/web.php' : [];
return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'extensions'=> require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => [
        'db'    => $mainConfig['components']['db']
    ],
    'modules' => $mainConfig['modules'],
];
