<?php

declare(strict_types=1);

namespace core\database;

use PDO;

class Connection
{
    private PDO $pdo;

    public function __construct(DatabaseDriver $driver, array $config)
    {
        $this->pdo = new PDO(
            $driver->getDsn($config),
            $driver->getUsername($config),
            $driver->getPassword($config),
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ],
        );
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
