<?php

declare(strict_types=1);

namespace StudentCorner\Shared\Infrastructure\Mail;

use PHPMailer\PHPMailer\PHPMailer;

final class PhpMailerFactory
{
    public static function create(): PHPMailer
    {
        $client = new PHPMailer(true);
        $client->isSMTP();
        $client->Host = 'localhost';
        $client->Port = 1_025;
        $client->setFrom('no-reply@student-corner.com', 'Student Corner Notification');

        return $client;
    }
}
