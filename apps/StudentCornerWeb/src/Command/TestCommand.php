<?php

declare(strict_types=1);

namespace StudentCornerWeb\Command;

use Faker\Factory;
use Faker\Generator;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Bus\Query\QueryBus;
use Shared\Domain\Logger;
use Shared\Domain\ValueObject\Uuid;
use StudentCorner\Offer\Application\Publish\PublishOfferCommand;
use StudentCorner\Offer\Domain\OfferRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TestCommand extends Command
{
    protected static $defaultName = 'test';
    /** @var Generator */
    private $faker;
    /** @var CommandBus */
    private $commandBus;
    /** @var QueryBus */
    private $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        parent::__construct();
        $this->faker = Factory::create();
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $command = new SendEmailCommand(Uuid::random()->value(), 'a@a.com', 'Pruebaaa', 'Esto es más que una prueba)');
        $userId = 'a4033f67-d9d2-4ce8-9943-eeea38316e33';
        $command = new PublishOfferCommand(
            Uuid::random()->value(),
            $this->faker->text(25),
            'Academia Nuria',
            'DAW',
            $this->faker->name(),
            $this->faker->numberBetween(1, 100),
            $userId
        );


        $this->commandBus->dispatch($command);
//        dump($this->queryBus->ask(new ShowScoreQuery($userId)));
    }
}
