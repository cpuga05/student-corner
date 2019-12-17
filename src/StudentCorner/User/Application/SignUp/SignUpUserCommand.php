<?php

declare(strict_types=1);

namespace StudentCorner\User\Application\SignUp;

use Shared\Domain\Bus\Command\Command;

final class SignUpUserCommand implements Command
{
    /** @var string */
    private string $id;
    /** @var string */
    private string $email;
    /** @var string */
    private string $password;

    public function __construct(string $id, string $email, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }

    public function id(): string
    {
        return $this->id;
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
