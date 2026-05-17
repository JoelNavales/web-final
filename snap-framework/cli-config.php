<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Core\database\Connection;
use Core\database\MySQLDriver;
use Core\database\SQLiteDriver;

$dbConfig = require __DIR__ . '/config/database.php';
$connName = $dbConfig['default'];
$connConf = $dbConfig['connections'][$connName];
$driver   = $connName === 'sqlite' ? new SQLiteDriver() : new MySQLDriver();

$entityManager = (new Connection($driver, $connConf))->getEntityManager();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::run(
    new \Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider($entityManager),
);
