<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Symfony;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Handler\HandlerDescriptor;
use Symfony\Component\Messenger\Handler\HandlersLocatorInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;

use function class_implements;
use function class_parents;
use function get_class;
use function in_array;

class ReorderHandlersLocator implements HandlersLocatorInterface
{
    private $handlers;

    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    public function getHandlers(Envelope $envelope): iterable
    {
        $seen = [];

        foreach (self::listTypes($envelope) as $type) {
            foreach ($this->handlers[$type] ?? [] as $handlerDescriptor) {
                if (\is_callable($handlerDescriptor)) {
                    $handlerDescriptor = new HandlerDescriptor($handlerDescriptor);
                }

                if (!$this->shouldHandle($envelope, $handlerDescriptor)) {
                    continue;
                }

                $name = $handlerDescriptor->getName();
                if (in_array($name, $seen, true)) {
                    continue;
                }

                $seen[] = $name;

                yield $handlerDescriptor;
            }
        }
    }

    public static function listTypes(Envelope $envelope): array
    {
        $class = get_class($envelope->getMessage());

        return class_parents($class)
            + class_implements($class)
            + [$class => $class]
            + ['*' => '*'];
    }

    private function shouldHandle(Envelope $envelope, HandlerDescriptor $handlerDescriptor): bool
    {
        if (null === $received = $envelope->last(ReceivedStamp::class)) {
            return true;
        }

        if (null === $expectedTransport = $handlerDescriptor->getOption('from_transport')) {
            return true;
        }

        return $received->getTransportName() === $expectedTransport;
    }
}
