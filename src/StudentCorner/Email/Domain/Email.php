<?php

declare(strict_types=1);

namespace StudentCorner\Email\Domain;

use StudentCorner\User\Domain\UserEmail;

final class Email
{
    private EmailId $id;
    private UserEmail $email;
    private EmailSubject $subject;
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
