<?php

declare(strict_types=1);

namespace snap\database;

interface Findable
{
    public function find(int $id): ?object;

    public function all(): array;
}
