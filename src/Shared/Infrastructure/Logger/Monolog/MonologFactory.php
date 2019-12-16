<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Logger\Monolog;

use Elastica\Client;
use Monolog\Handler\ElasticaHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;

final class MonologFactory
{
    public static function create(array $elastic): Logger
    {
        return new Logger(
            'student-corner',
            [
                new ElasticaHandler(
                    new Client(['host' => $elastic['host'], 'port' => $elastic['port']]),
                    ['index' => 'domain-events', 'type' => 'event']
                ),
            ],
            [
                new WebProcessor(),
                new IntrospectionProcessor(),
                new MemoryUsageProcessor(),
                new MemoryPeakUsageProcessor(),
            ]
        );
    }
}
