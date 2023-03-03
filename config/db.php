<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mariadb;dbname=testdb',
    'username' => 'testuser',
    'password' => 'testpassword',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
