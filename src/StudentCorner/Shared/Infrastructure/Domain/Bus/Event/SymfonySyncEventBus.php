<?php

declare(strict_types=1);

namespace StudentCorner\Shared\Infrastructure\Domain\Bus\Event;

use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\Bus\Event\EventBus;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

use function dump;

class SymfonySyncEventBus implements EventBus
{
    /** @var MessageBus */
    private $bus;

    public function __construct(iterable $subscribers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(new HandlersLocator($this->subscribers($subscribers))),
            ]
        );
    }

    private function subscribers(iterable $subscribers): array
    {
        $subs = [];

        foreach ($subscribers as $subscriber) {
            $subscribedEvents = $subscriber::subscribedTo();

            foreach ($subscribedEvents as $subscribedEvent) {
                $subs[$subscribedEvent][] = $subscriber;
            }
        }

        return $subs;
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->bus->dispatch($event);
            } catch (NoHandlerForMessageException $exception) {
            }
        }
    }
}
