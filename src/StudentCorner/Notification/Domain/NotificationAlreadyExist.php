<?php

declare(strict_types=1);

namespace StudentCorner\Notification\Domain;

use Shared\Domain\DomainError;
use StudentCorner\Offer\Domain\OfferId;

use function sprintf;

final class NotificationAlreadyExist extends DomainError
{
    /** @var NotificationId */
    private NotificationId $id;

    public function __construct(NotificationId $id)
    {
        $this->id = $id;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'notification.already_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The notification <%s> already exist', $this->id->value());
    }
}
