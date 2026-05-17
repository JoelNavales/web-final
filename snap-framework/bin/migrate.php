<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use core\database\Connection;
use core\database\MySQLDriver;
use core\database\SQLiteDriver;

$dbConfig = require __DIR__ . '/../config/database.php';
$connName = $dbConfig['default'];
$connConf = $dbConfig['connections'][$connName];
$driver   = $connName === 'sqlite' ? new SQLiteDriver() : new MySQLDriver();
$pdo      = (new Connection($driver, $connConf))->getPdo();

if ($connName === 'sqlite') {
    $pdo->exec("CREATE TABLE IF NOT EXISTS tasks (
        id          INTEGER PRIMARY KEY AUTOINCREMENT,
        title       VARCHAR(255) NOT NULL,
        description TEXT,
        status      VARCHAR(50)  NOT NULL DEFAULT 'pending',
        due_date    DATE,
        created_at  DATETIME     NOT NULL,
        updated_at  DATETIME     NOT NULL
    )");
} else {
    $pdo->exec("CREATE TABLE IF NOT EXISTS tasks (
        id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
        title       VARCHAR(255) NOT NULL,
        description TEXT,
        status      ENUM('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
        due_date    DATE,
        created_at  DATETIME NOT NULL,
        updated_at  DATETIME NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

echo "Migration complete.\n";
