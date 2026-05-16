<?php

declare(strict_types=1);

namespace snap\database;

interface Persistable
{
    public function save(object $entity): void;

    public function delete(object $entity): void;
}
