<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Shared\Domain\Aggregate\AggregateRoot;

abstract class DoctrineRepository
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    abstract protected function entity(): String;

    protected function entityManager(): EntityManager
    {
        return $this->entityManager;
    }

    protected function persist(AggregateRoot $entity): void
    {
        $this->entityManager()->persist($entity);
//        $this->entityManager()->flush($entity);
    }

    protected function remove(AggregateRoot $entity): void
    {
        $this->entityManager()->remove($entity);
//        $this->entityManager()->flush($entity);
    }

    protected function repository(?string $entityClass = null): EntityRepository
    {
        if (null === $entityClass) {
            return $this->entityManager()->getRepository($this->entity());
        }

        return $this->entityManager()->getRepository($entityClass);
    }

    protected function queryBuilder(): QueryBuilder
    {
        return $this->entityManager()->createQueryBuilder();
    }
}
