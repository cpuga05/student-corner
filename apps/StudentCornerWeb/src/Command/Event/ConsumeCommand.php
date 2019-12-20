<?php

declare(strict_types=1);

namespace StudentCornerWeb\Command\Event;

use Shared\Application\Event\Consume\ConsumeEventsService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ConsumeCommand extends Command
{
    protected static $defaultName = 'event:consume';
    private ConsumeEventsService $consumeEventsService;

    public function __construct(ConsumeEventsService $consumeEventsService)
    {
        parent::__construct(null);
        $this->consumeEventsService = $consumeEventsService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Consume domain events')
            ->addArgument('queue', InputArgument::REQUIRED, 'Queue name')
            ->addArgument('quantity', InputArgument::REQUIRED, 'Quantity of events to process');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $queueName = $input->getArgument('queue');
        $eventsToProcess = (int)$input->getArgument('quantity');

        $this->consumeEventsService->__invoke($queueName, $eventsToProcess);
    }
}
