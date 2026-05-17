<?php

declare(strict_types=1);

namespace core\database;

class SQLiteDriver implements DatabaseDriver
{
    public function getConnectionParams(array $config): array
    {
        return [
            'driver' => 'pdo_sqlite',
            'path'   => $config['database'],
        ];
    }
}
