<?php

declare(strict_types=1);

namespace StudentCorner\Shared\Infrastructure\Domain\Bus\Command;

use BadMethodCallException;
use ReflectionClass;
use Shared\Domain\Bus\Command\Command;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineTransactionMiddleware;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class SymfonySyncCommandBus implements CommandBus
{
    private MessageBus $bus;

    public function __construct(iterable $commandHandlers, DoctrineTransactionMiddleware $doctrineTransactionMiddleware)
    {
        $this->bus = new MessageBus(
            [
                $doctrineTransactionMiddleware,
                new HandleMessageMiddleware(new HandlersLocator($this->handlers($commandHandlers))),
            ]
        );
    }

    private function handlers(iterable $commandHandlers): array
    {
        $handlers = [];

        foreach ($commandHandlers as $commandHandler) {
            $reflection = new ReflectionClass($commandHandler);

            if (!$reflection->hasMethod('__invoke')) {
                continue;
            }

            $method = $reflection->getMethod('__invoke');

            if ($method->getNumberOfParameters() > 1) {
                continue;
            }

            $command = $method->getParameters()[0]->getClass()->getName();

            $handlers[$command] = [$commandHandler];
        }

        return $handlers;
    }

    public function dispatch(Command $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException $exception) {
            throw new BadMethodCallException('Command not registered');
        }
    }
}
