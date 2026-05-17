<?php

declare(strict_types=1);

namespace core\database;

use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;

class QueryBuilder
{
    public function __construct(
        private DoctrineQueryBuilder $qb,
    ) {}

    public function where(string $condition, string $param, mixed $value): static
    {
        $this->qb->where($condition)->setParameter($param, $value);
        return $this;
    }

    public function orderBy(string $field, string $direction = 'ASC'): static
    {
        $this->qb->orderBy($field, $direction);
        return $this;
    }

    public function get(): array
    {
        return $this->qb->getQuery()->getResult();
    }

    public function first(): ?object
    {
        return $this->qb->setMaxResults(1)->getQuery()->getOneOrNullResult();
    }
}
