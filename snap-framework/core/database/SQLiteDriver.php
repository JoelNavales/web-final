<?php

declare(strict_types=1);

namespace core\database;

class SQLiteDriver implements DatabaseDriver
{
    public function getDsn(array $config): string
    {
        return "sqlite:{$config['database']}";
    }

    public function getUsername(array $config): ?string
    {
        return null;
    }

    public function getPassword(array $config): ?string
    {
        return null;
    }
}
