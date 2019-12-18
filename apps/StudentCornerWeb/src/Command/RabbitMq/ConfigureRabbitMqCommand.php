<?php

declare(strict_types=1);

namespace StudentCornerWeb\Command\RabbitMq;

use Shared\Infrastructure\Queue\RabbitMq\RabbitMqConfigurator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Traversable;

use function iterator_to_array;

final class ConfigureRabbitMqCommand extends Command
{
    protected static $defaultName = 'rmq:configure';
    private RabbitMqConfigurator $configurator;
    private string $exchangeName;
    private Traversable $domainEventSubscribers;

    public function __construct(
        RabbitMqConfigurator $configurator,
        string $exchangeName,
        Traversable $domainEventSubscribers
    ) {
        parent::__construct();

        $this->configurator = $configurator;
        $this->exchangeName = $exchangeName;
        $this->domainEventSubscribers = $domainEventSubscribers;
    }

    protected function configure(): void
    {
        $this->setDescription('Configure the RabbitMQ to allow publish & consume domain events');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->configurator->configure($this->exchangeName, ...iterator_to_array($this->domainEventSubscribers));
    }
}
