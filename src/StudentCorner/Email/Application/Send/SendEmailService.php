<?php

declare(strict_types=1);

namespace StudentCorner\Email\Application\Send;

use Shared\Domain\Bus\Event\EventBus;
use StudentCorner\Email\Domain\Email;
use StudentCorner\Email\Domain\EmailBody;
use StudentCorner\Email\Domain\EmailId;
use StudentCorner\Email\Domain\EmailSender;
use StudentCorner\Email\Domain\EmailSubject;
use StudentCorner\User\Domain\UserEmail;

final class SendEmailService
{
    /** @var EmailSender */
    private $sender;
    /** @var EventBus */
    private $eventBus;

    public function __construct(EmailSender $sender, EventBus $eventBus)
    {
        $this->sender = $sender;
        $this->eventBus = $eventBus;
    }

    public function __invoke(EmailId $id, UserEmail $email, EmailSubject $subject, EmailBody $body): void
    {
        $mail = new Email($id, $email, $subject, $body);

        $this->sender->send($mail);
    }
}
