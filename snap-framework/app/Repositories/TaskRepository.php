<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Task;
use App\Models\TaskStatus;
use core\database\EntityRepository;
use core\database\Model;
use DateTimeImmutable;

class TaskRepository extends EntityRepository implements TaskRepositoryInterface
{
    protected function getTable(): string
    {
        return 'tasks';
    }

    protected function mapRowToEntity(array $row): Task
    {
        $task = new Task($row['title'], TaskStatus::from($row['status']));
        $task->setDescription($row['description']);
        $task->setDueDate($row['due_date'] !== null ? new DateTimeImmutable($row['due_date']) : null);
        $task->hydrate($row);

        return $task;
    }

    protected function mapEntityToRow(Model $entity): array
    {
        assert($entity instanceof Task);

        return [
            'title'       => $entity->getTitle(),
            'description' => $entity->getDescription(),
            'status'      => $entity->getStatus()->value,
            'due_date'    => $entity->getDueDate()?->format('Y-m-d'),
        ];
    }

    public function findByStatus(TaskStatus $status): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTable()} WHERE status = ?");
        $stmt->execute([$status->value]);

        return array_map([$this, 'mapRowToEntity'], $stmt->fetchAll());
    }
}
