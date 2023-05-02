<?php

/**
 * Database config
 */

require dirname(__DIR__, 1) . '/config-env.php';

return [
    'database' => [
        'dbname' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
        'host' => $_ENV['DB_HOSTNAME'],
        'driver' => 'pdo_mysql',
    ]
];
