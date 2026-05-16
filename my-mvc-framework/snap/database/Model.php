<?php

declare(strict_types=1);

namespace snap\database;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class Model
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected ?int $id = null;

    #[ORM\Column(type: 'datetime_immutable')]
    protected ?DateTimeImmutable $created_at = null;

    #[ORM\Column(type: 'datetime_immutable')]
    protected ?DateTimeImmutable $updated_at = null;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->created_at ??= new DateTimeImmutable();
        $this->updated_at   = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updated_at = new DateTimeImmutable();
    }

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
}
