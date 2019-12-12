<?php

declare(strict_types=1);

namespace StudentCorner\User\Domain;

use Shared\Domain\Bus\Event\DomainEvent;

final class UserSignedUpDomainEvent extends DomainEvent
{
    /** @var string */
    private $email;

    public function __construct(string $id, string $email, string $eventId = null, string $occurredOn = null)
    {
        parent::__construct($id, $eventId, $occurredOn);
        $this->email = $email;
    }

    public static function create(User $user): self
    {
        return new self($user->id()->value(), $user->email()->value());
    }

    public function eventName(): string
    {
        return 'user.signed_up';
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
