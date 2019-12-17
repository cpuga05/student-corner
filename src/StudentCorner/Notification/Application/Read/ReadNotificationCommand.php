<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application\Read;

use Shared\Domain\Bus\Command\Command;

final class ReadNotificationCommand implements Command
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
