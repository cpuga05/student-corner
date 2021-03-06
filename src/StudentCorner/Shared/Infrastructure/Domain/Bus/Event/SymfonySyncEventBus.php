<?php

declare(strict_types=1);

namespace StudentCorner\Shared\Infrastructure\Domain\Bus\Event;

use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\Bus\Event\EventBus;
use Shared\Infrastructure\Symfony\ReorderHandlersLocator;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class SymfonySyncEventBus implements EventBus
{
    private MessageBus $bus;

    public function __construct(iterable $subscribers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(new ReorderHandlersLocator($this->subscribers($subscribers))),
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
