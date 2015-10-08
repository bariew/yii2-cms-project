<?php
$serverName = preg_replace('/\:\d+/', '', $_SERVER['HTTP_HOST']);
require(__DIR__ . '/../vendor/autoload.php');
$config = require(__DIR__ . '/../config/web.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
(new yii\web\Application($config))->run();
