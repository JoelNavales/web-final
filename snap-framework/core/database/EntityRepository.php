<?php

declare(strict_types=1);

namespace core\database;

use DateTimeImmutable;
use PDO;

abstract class EntityRepository implements Findable, Persistable
{
    public function __construct(protected PDO $pdo) {}

    abstract protected function getTable(): string;
    abstract protected function mapRowToEntity(array $row): Model;
    abstract protected function mapEntityToRow(Model $entity): array;

    public function find(int $id): ?Model
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTable()} WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row !== false ? $this->mapRowToEntity($row) : null;
    }

    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->getTable()}");

        return array_map([$this, 'mapRowToEntity'], $stmt->fetchAll());
    }

    public function save(Model $entity): void
    {
        $now  = (new DateTimeImmutable())->format('Y-m-d H:i:s');
        $data = $this->mapEntityToRow($entity);

        if ($entity->getId() === null) {
            $data['created_at'] = $now;
            $data['updated_at'] = $now;
            $columns      = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));

            $this->pdo->prepare(
                "INSERT INTO {$this->getTable()} ({$columns}) VALUES ({$placeholders})",
            )->execute(array_values($data));

            $entity->hydrate([
                'id'         => (int) $this->pdo->lastInsertId(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            $data['updated_at'] = $now;
            $sets = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($data)));

            $this->pdo->prepare(
                "UPDATE {$this->getTable()} SET {$sets} WHERE id = ?",
            )->execute([...array_values($data), $entity->getId()]);

            $entity->hydrate(['updated_at' => $now]);
        }
    }

    public function delete(Model $entity): void
    {
        $this->pdo->prepare("DELETE FROM {$this->getTable()} WHERE id = ?")
            ->execute([$entity->getId()]);
    }
}
