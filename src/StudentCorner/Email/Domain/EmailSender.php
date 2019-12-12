<?php

namespace StudentCorner\Email\Domain;

interface EmailSender
{
    public function send(Email $email): void;
}
