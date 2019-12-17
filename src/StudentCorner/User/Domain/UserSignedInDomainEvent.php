<?php

declare(strict_types=1);

namespace StudentCorner\User\Domain;

use Shared\Domain\Bus\Event\DomainEvent;

final class UserSignedInDomainEvent extends DomainEvent
{
    /** @var string */
    private string $email;

    public function __construct(string $aggregateId, string $email, string $eventId = null, string $occurredOn = null)
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
        $this->email = $email;
    }

    public static function create(UserSecurityToken $securityToken): self
    {
        return new self($securityToken->id()->value(), $securityToken->email()->value());
    }

    public function eventName(): string
    {
        return 'user.signed_in';
    }

    public function toPrimitives(): array
    {
        return [
            'email' => $this->email,
        ];
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self($aggregateId, $body['email'], $eventId, $occurredOn);
    }

    public function email(): string
    {
        return $this->email;
    }
}
