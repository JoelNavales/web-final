<?php

declare(strict_types=1);

namespace core\database;

interface DatabaseDriver
{
    public function getDsn(array $config): string;
    public function getUsername(array $config): ?string;
    public function getPassword(array $config): ?string;
}
