<?php

declare(strict_types=1);

namespace StudentCorner\Email\Application\Send;

use Shared\Domain\Bus\Event\DomainEventSubscriber;
use Shared\Domain\Bus\Query\QueryBus;
use StudentCorner\Email\Domain\Email;
use StudentCorner\Email\Domain\EmailBody;
use StudentCorner\Email\Domain\EmailId;
use StudentCorner\Email\Domain\EmailSubject;
use StudentCorner\Offer\Domain\OfferPublished;
use StudentCorner\User\Application\UserResponse;
use StudentCorner\User\Application\View\ViewUserQuery;
use StudentCorner\User\Domain\UserEmail;

final class SendEmailOnOfferPublished implements DomainEventSubscriber
{
    /** @var SendEmailService */
    private SendEmailService $sender;
    /** @var QueryBus */
    private QueryBus $queryBus;

    public function __construct(SendEmailService $service, QueryBus $queryBus)
    {
        $this->sender = $service;
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
        $id = EmailId::random();
        $email = new UserEmail($user->email());
        $subject = new EmailSubject('New offer published');
        $body = new EmailBody('You publish new offer: ' . $offerPublished->name());

        $this->sender->__invoke($id, $email, $subject, $body);
    }
}
