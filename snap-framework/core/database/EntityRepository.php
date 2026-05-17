<?php

declare(strict_types=1);

namespace core\database;

use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;

/**
 * Extends Doctrine's EntityRepository (required by DefaultRepositoryFactory)
 * and adds the Findable + Persistable contract (ISP).
 *
 * find(mixed $id) is inherited from DoctrineEntityRepository and satisfies
 * Findable::find(int $id) via PHP's contravariant parameter widening rule.
 */
abstract class EntityRepository extends DoctrineEntityRepository implements Findable, Persistable
{
    public function all(): array
    {
        return $this->findAll();
    }

    public function save(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function delete(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
}
