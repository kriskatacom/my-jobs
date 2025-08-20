<?php

return [
    'host'     => $_ENV['DB_HOST']     ?? 'localhost',
    'dbname'   => $_ENV['DB_NAME']     ?? 'my_database',
    'username' => $_ENV['DB_USER']     ?? 'root',
    'password' => $_ENV['DB_PASS']     ?? '',
    'charset'  => $_ENV['DB_CHARSET']  ?? 'utf8mb4'
];
