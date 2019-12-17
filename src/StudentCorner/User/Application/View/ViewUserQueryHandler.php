<?php

declare(strict_types=1);

namespace StudentCorner\User\Application\View;

use Shared\Domain\Bus\Query\QueryHandler;
use StudentCorner\User\Application\UserResponse;
use StudentCorner\User\Domain\UserId;

final class ViewUserQueryHandler implements QueryHandler
{
    /** @var ViewUserService */
    private ViewUserService $service;

    public function __construct(ViewUserService $service)
    {
        $this->service = $service;
    }

    public function __invoke(ViewUserQuery $query): UserResponse
    {
        $id = new UserId($query->id());
        $user = $this->service->__invoke($id);

        return UserResponse::fromUser($user);
    }
}
