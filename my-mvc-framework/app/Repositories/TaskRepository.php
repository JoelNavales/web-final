<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Task;
use App\Models\TaskStatus;
use snap\database\EntityRepository;

class TaskRepository extends EntityRepository implements TaskRepositoryInterface
{
    public function findByStatus(TaskStatus $status): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.status = :status')
            ->setParameter('status', $status->value)
            ->getQuery()
            ->getResult();
    }
}
