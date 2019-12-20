<?php

declare(strict_types=1);

namespace StudentCornerWeb\Command\Event;

use Shared\Application\Event\Push\PushEventService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class PushCommand extends Command
{
    protected static $defaultName = 'event:push';
    private PushEventService $pushEventService;

    public function __construct(PushEventService $pushEventService)
    {
        parent::__construct(null);
        $this->pushEventService = $pushEventService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Push all event since last pushed')
            ->addArgument('channel', InputArgument::REQUIRED, 'Channel')
            ->addOption('force', 'f', InputOption::VALUE_OPTIONAL, 'Force push', false);
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $channel = $input->getArgument('channel');
        $force = $input->getOption('force') ?? true;
        $events = $this->pushEventService->__invoke($channel, $force);

        $output->writeln("<comment>$events</comment> <info>events pushed!</info>");
    }
}
