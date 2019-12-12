<?php

declare(strict_types=1);

namespace StudentCorner\User\Infrastructure;

use Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use StudentCorner\User\Domain\User;
use StudentCorner\User\Domain\UserEmail;
use StudentCorner\User\Domain\UserId;
use StudentCorner\User\Domain\UserRepository;

final class DoctrineUserRepository extends DoctrineRepository implements UserRepository
{
    protected function entity(): String
    {
        return User::class;
    }

    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function delete(User $user): void
    {
        $this->remove($user);
    }

    public function findById(UserId $id): ?User
    {
        return $this->repository()->find($id);
    }

    public function findByEmail(UserEmail $email): ?User
    {
        return $this->repository()->findOneBy(['email' => $email->value()]);
    }
}
