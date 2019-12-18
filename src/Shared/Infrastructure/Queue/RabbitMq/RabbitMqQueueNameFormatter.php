<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Queue\RabbitMq;

use Shared\Domain\Bus\Event\DomainEventConsumer;
use Shared\Domain\Bus\Event\DomainEventSubscriber;
use Shared\Domain\Utils;

use function explode;
use function get_class;
use function implode;
use function Lambdish\Phunctional\last;
use function Lambdish\Phunctional\map;

final class RabbitMqQueueNameFormatter
{
    public static function format(DomainEventConsumer $domainEventSubscriber): string
    {
        $subscriberClassPaths = explode('\\', get_class($domainEventSubscriber));

        $queueNameParts = [
            $subscriberClassPaths[0],
            last($subscriberClassPaths),
        ];

        return implode('.', map(fn(string $text) => Utils::toSnakeCase($text), $queueNameParts));
    }

    public static function formatRetry(DomainEventConsumer $domainEventSubscriber): string
    {
        $queueName = self::format($domainEventSubscriber);

        return 'retry-' . $queueName;
    }

    public static function formatDeadLetter(DomainEventConsumer $domainEventSubscriber): string
    {
        $queueName = self::format($domainEventSubscriber);

        return 'dead_letter-' . $queueName;
    }

    public static function shortFormat(DomainEventConsumer $domainEventSubscriber): string
    {
        $subscriberCamelCaseName = (string)last(explode('\\', get_class($domainEventSubscriber)));

        return Utils::toSnakeCase($subscriberCamelCaseName);
    }
}
