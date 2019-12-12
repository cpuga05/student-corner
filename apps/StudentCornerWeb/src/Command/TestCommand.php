<?php

declare(strict_types=1);

namespace StudentCornerWeb\Command;

use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\ValueObject\Uuid;
use StudentCorner\Offer\Application\Publish\PublishOfferCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TestCommand extends Command
{
    protected static $defaultName = 'test';
    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $command = new SendEmailCommand(Uuid::random()->value(), 'a@a.com', 'Pruebaaa', 'Esto es más que una prueba)');
        $command = new PublishOfferCommand(
            Uuid::random()->value(),
            'Name',
            'Academia Nuria',
            'DAW',
            'Jose',
            123,
            'a4033f67-d9d2-4ce8-9943-eeea38316e33'
        );

        $this->commandBus->dispatch($command);
    }
}
