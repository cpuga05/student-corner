<?php

declare(strict_types=1);

namespace StudentCorner\Email\Application\Send;

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

    public function __construct(EmailSender $sender)
    {
        $this->sender = $sender;
    }

    public function __invoke(EmailId $id, UserEmail $email, EmailSubject $subject, EmailBody $body): void
    {
        $mail = new Email($id, $email, $subject, $body);

        $this->sender->send($mail);
    }
}
