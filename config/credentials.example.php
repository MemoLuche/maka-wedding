<?php
// Copy this file to config/credentials.php and fill in your values.
// config/credentials.php is git-ignored: never commit real credentials.
return [
    'production' => [
        'db_host'     => 'your-db-host',
        'db_name'     => 'your-db-name',
        'db_user'     => 'your-db-user',
        'db_password' => 'your-db-password',
        'db_port'     => 3306,
    ],
    // Admin panel login. Generate the hash with:
    //   php -r "echo password_hash('your-password', PASSWORD_DEFAULT), PHP_EOL;"
    'admin' => [
        'username'      => 'admin',
        'password_hash' => '',
    ],
];
