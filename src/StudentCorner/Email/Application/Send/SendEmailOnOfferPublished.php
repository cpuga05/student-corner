<?php

declare(strict_types=1);

namespace StudentCorner\Email\Application\Send;

use Shared\Domain\Bus\Event\DomainEventSubscriber;
use Shared\Domain\Bus\Query\QueryBus;
use StudentCorner\Email\Domain\Email;
use StudentCorner\Email\Domain\EmailBody;
use StudentCorner\Email\Domain\EmailId;
use StudentCorner\Email\Domain\EmailSender;
use StudentCorner\Email\Domain\EmailSubject;
use StudentCorner\Offer\Domain\OfferPublished;
use StudentCorner\User\Application\UserResponse;
use StudentCorner\User\Application\View\ViewUserQuery;
use StudentCorner\User\Domain\UserEmail;

final class SendEmailOnOfferPublished implements DomainEventSubscriber
{
    /** @var EmailSender */
    private $sender;
    /** @var QueryBus */
    private $queryBus;

    public function __construct(EmailSender $sender, QueryBus $queryBus)
    {
        $this->sender = $sender;
        $this->queryBus = $queryBus;
    }

    public static function subscribedTo(): array
    {
        return [OfferPublished::class];
    }

    public function __invoke(OfferPublished $offerPublished): void
    {
        /** @var UserResponse $user */
        $user = $this->queryBus->ask(new ViewUserQuery($offerPublished->userId()));
        $email = new Email(
            EmailId::random(),
            new UserEmail($user->email()),
            new EmailSubject('New offer published'),
            new EmailBody('You publish new offer: ' . $offerPublished->name())
        );

        $this->sender->send($email);
    }
}