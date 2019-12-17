<?php

declare(strict_types=1);

namespace StudentCorner\User\Application\View;

use StudentCorner\User\Domain\User;
use StudentCorner\User\Domain\UserId;
use StudentCorner\User\Domain\UserNotFound;
use StudentCorner\User\Domain\UserRepository;

final class ViewUserService
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserId $id): User
    {
        $user = $this->repository->findById($id);

        if (null === $user) {
            throw new UserNotFound($id);
        }

        return $user;
    }
}
