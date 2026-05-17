<?php

declare(strict_types=1);

namespace core\database;

interface DatabaseDriver
{
    public function getConnectionParams(array $config): array;
}
