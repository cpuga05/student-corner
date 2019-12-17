<?php

declare(strict_types=1);

namespace StudentCorner\User\Application;

use Shared\Domain\Bus\Query\Response;
use StudentCorner\User\Domain\User;

final class UserResponse implements Response
{
    private string $id;
    private string $email;

    public function __construct(string $id, string $email)
    {
        $this->id = $id;
        $this->email = $email;
    }

    public static function fromUser(User $user): self
    {
        return new self($user->id()->value(), $user->email()->value());
    }

    public function id(): string
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }
}
