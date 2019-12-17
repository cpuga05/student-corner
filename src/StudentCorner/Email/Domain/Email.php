<?php

declare(strict_types=1);

namespace StudentCorner\Email\Domain;

use StudentCorner\User\Domain\UserEmail;

final class Email
{
    /** @var EmailId */
    private EmailId $id;
    /** @var UserEmail */
    private UserEmail $email;
    /** @var EmailSubject */
    private EmailSubject $subject;
    /** @var EmailBody */
    private EmailBody $body;

    public function __construct(EmailId $id, UserEmail $email, EmailSubject $subject, EmailBody $body)
    {
        $this->id = $id;
        $this->email = $email;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function id(): EmailId
    {
        return $this->id;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function subject(): EmailSubject
    {
        return $this->subject;
    }

    public function body(): EmailBody
    {
        return $this->body;
    }
}
