<?php

declare(strict_types=1);

namespace StudentCorner\Email\Infrastructure;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use RuntimeException;
use StudentCorner\Email\Domain\Email;
use StudentCorner\Email\Domain\EmailSender;

final class PhpMailerEmailSender implements EmailSender
{
    /** @var PHPMailer */
    private $client;

    public function __construct(PHPMailer $client)
    {
        $this->client = $client;
    }

    public function send(Email $email): void
    {
        try {
            $this->client->addAddress($email->email()->value());
            $this->client->Subject = $email->subject()->value();
            $this->client->Body = $email->body()->value();
            $this->client->send();
        } catch (Exception $exception) {
            throw new RuntimeException('Error to send email');
        }
    }
}
