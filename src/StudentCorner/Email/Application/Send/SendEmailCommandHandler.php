<?php

declare(strict_types=1);

namespace StudentCorner\Email\Application\Send;

use Shared\Domain\Bus\Command\CommandHandler;
use StudentCorner\Email\Domain\EmailBody;
use StudentCorner\Email\Domain\EmailId;
use StudentCorner\Email\Domain\EmailSubject;
use StudentCorner\User\Domain\UserEmail;

final class SendEmailCommandHandler implements CommandHandler
{
    private SendEmailService $service;

    public function __construct(SendEmailService $service)
    {
        $this->service = $service;
    }

    public function __invoke(SendEmailCommand $command): void
    {
        $id = new EmailId($command->id());
        $email = new UserEmail($command->email());
        $subject = new EmailSubject($command->subject());
        $body = new EmailBody($command->body());

        $this->service->__invoke($id, $email, $subject, $body);
    }
}
