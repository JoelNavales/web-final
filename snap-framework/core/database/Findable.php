<?php

declare(strict_types=1);

namespace core\database;

interface Findable
{
    public function find(int $id): ?Model;

    public function all(): array;
}
