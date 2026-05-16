<?php

declare(strict_types=1);

namespace snap\database;

interface DatabaseDriver
{
    public function getConnectionParams(array $config): array;
}
