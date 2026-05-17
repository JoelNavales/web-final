<?php

declare(strict_types=1);

namespace core\database;

use DateTimeImmutable;

abstract class Model
{
    protected ?int $id = null;
    protected ?DateTimeImmutable $created_at = null;
    protected ?DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function hydrate(array $row): void
    {
        if (array_key_exists('id', $row)) {
            $this->id = $row['id'] !== null ? (int) $row['id'] : null;
        }
        if (array_key_exists('created_at', $row)) {
            $this->created_at = $row['created_at'] !== null
                ? new DateTimeImmutable($row['created_at']) : null;
        }
        if (array_key_exists('updated_at', $row)) {
            $this->updated_at = $row['updated_at'] !== null
                ? new DateTimeImmutable($row['updated_at']) : null;
        }
    }
}
