<?php return array (
  'id' => 'Yii2 CMS',
  'language' => 'en',
  'components' => 
  array (
    'db' => 
    array (
      'class' => 'yii\\db\\Connection',
      'dsn' => 'mysql:host=localhost;dbname=myDatabaseName',
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',
      'enableSchemaCache' => true,
      'schemaCacheDuration' => 3600,
    ),
  ),
  'params' => 
  array (
    'adminEmail' => 'admin@mysite.com',
  ),
);