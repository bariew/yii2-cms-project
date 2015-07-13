<?php
/**
 * Application configuration shared by all test types
 */
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=test',
            'username' => 'root',
            'password' => 'root',
        ],
    ],
];
