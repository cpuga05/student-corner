<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Domain;

use Shared\Domain\DomainError;

use function sprintf;

final class NotificationNotExist extends DomainError
{
    private NotificationId $id;

    public function __construct(NotificationId $id)
    {
        $this->id = $id;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'notification.not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The notification <%s> not exist', $this->id->value());
    }
}
