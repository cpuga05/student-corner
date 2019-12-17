<?php

declare(strict_types=1);

namespace StudentCorner\Shared\Infrastructure\Domain\Bus\Query;

use BadMethodCallException;
use ReflectionClass;
use Shared\Domain\Bus\Query\Query;
use Shared\Domain\Bus\Query\QueryBus;
use Shared\Domain\Bus\Query\Response;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonySyncQueryBus implements QueryBus
{
    private MessageBus $bus;

    public function __construct(iterable $queryHandlers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(new HandlersLocator($this->handlers($queryHandlers))),
            ]
        );
    }

    private function handlers(iterable $queryHandlers): array
    {
        $handlers = [];

        foreach ($queryHandlers as $queryHandler) {
            $reflection = new ReflectionClass($queryHandler);

            if (!$reflection->hasMethod('__invoke')) {
                continue;
            }

            $method = $reflection->getMethod('__invoke');

            if ($method->getNumberOfParameters() > 1) {
                continue;
            }

            $query = $method->getParameters()[0]->getClass()->getName();

            $handlers[$query] = [$queryHandler];
        }

        return $handlers;
    }

    public function ask(Query $query): Response
    {
        try {
            /** @var HandledStamp $stamp */
            $stamp = $this->bus->dispatch($query)->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (NoHandlerForMessageException $exception) {
            throw new BadMethodCallException('Query not registered');
        }
    }
}
