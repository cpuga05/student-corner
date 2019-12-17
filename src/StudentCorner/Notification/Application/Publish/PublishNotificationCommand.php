<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Application\Publish;

use Shared\Domain\Bus\Command\Command;

final class PublishNotificationCommand implements Command
{
    /** @var string */
    private string $id;
    /** @var string */
    private string $type;
    /** @var string */
    private string $destination;
    /** @var string */
    private string $body;
    /** @var string */
    private string $userId;

    public function __construct(
        string $id,
        string $type,
        string $destination,
        string $body,
        string $userId
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->destination = $destination;
        $this->body = $body;
        $this->userId = $userId;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function destination(): string
    {
        return $this->destination;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function userId(): string
    {
        return $this->userId;
    }
}
