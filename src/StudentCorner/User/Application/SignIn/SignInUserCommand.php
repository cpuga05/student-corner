<?php

declare(strict_types=1);

namespace StudentCorner\User\Application\SignIn;

use Shared\Domain\Bus\Command\Command;

final class SignInUserCommand implements Command
{
    private string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
