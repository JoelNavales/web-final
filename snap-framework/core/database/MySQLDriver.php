<?php

declare(strict_types=1);

namespace core\database;

class MySQLDriver implements DatabaseDriver
{
    public function getDsn(array $config): string
    {
        $host    = $config['host']    ?? '127.0.0.1';
        $port    = $config['port']    ?? 3306;
        $dbname  = $config['database'];
        $charset = $config['charset'] ?? 'utf8mb4';

        return "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";
    }

    public function getUsername(array $config): ?string
    {
        return $config['username'];
    }

    public function getPassword(array $config): ?string
    {
        return $config['password'];
    }
}
