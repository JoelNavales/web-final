<?php

declare(strict_types=1);

namespace core\database;

interface Persistable
{
    public function save(Model $entity): void;

    public function delete(Model $entity): void;
}
