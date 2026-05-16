<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Core\database\Connection;
use Core\database\MySQLDriver;
use Core\database\SQLiteDriver;
use Doctrine\ORM\Tools\SchemaTool;

$dbConfig = require __DIR__ . '/../config/database.php';
$connName = $dbConfig['default'];
$connConf = $dbConfig['connections'][$connName];
$driver   = $connName === 'sqlite' ? new SQLiteDriver() : new MySQLDriver();

$em         = (new Connection($driver, $connConf))->getEntityManager();
$schemaTool = new SchemaTool($em);
$classes    = $em->getMetadataFactory()->getAllMetadata();

$command = $argv[1] ?? '';

match ($command) {
    'schema:create' => (static function () use ($schemaTool, $classes): void {
        $schemaTool->createSchema($classes);
        echo "Schema created successfully.\n";
    })(),
    'schema:update' => (static function () use ($schemaTool, $classes): void {
        $schemaTool->updateSchema($classes);
        echo "Schema updated successfully.\n";
    })(),
    default => (static function (): void {
        echo "PHP MVC Framework — Doctrine Console\n\n";
        echo "Available commands:\n";
        echo "  schema:create   Create the database schema from entity metadata\n";
        echo "  schema:update   Update the database schema to match entity metadata\n";
    })(),
};
