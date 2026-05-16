<?php

declare(strict_types=1);

namespace snap\database;

class MySQLDriver implements DatabaseDriver
{
    public function getConnectionParams(array $config): array
    {
        return [
            'driver'   => 'pdo_mysql',
            'host'     => $config['host']     ?? '127.0.0.1',
            'port'     => $config['port']     ?? 3306,
            'dbname'   => $config['database'],
            'user'     => $config['username'],
            'password' => $config['password'],
            'charset'  => $config['charset']  ?? 'utf8mb4',
        ];
    }
}
