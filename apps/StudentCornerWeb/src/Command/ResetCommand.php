<?php

declare(strict_types=1);

namespace StudentCornerWeb\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\SchemaTool;
use Shared\Domain\Bus\Command\CommandBus;
use StudentCorner\User\Application\SignUp\SignUpUserCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function count;
use function Lambdish\Phunctional\reduce;

final class ResetCommand extends Command
{
    protected static $defaultName = 'reset';
    private EntityManager $entityManager;
    private CommandBus $commandBus;

    public function __construct(EntityManager $entityManager, CommandBus $commandBus)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->commandBus = $commandBus;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->entityManager);
        $tables = $this->countTables($metadata);

        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
        $this->writeLine($output, 'Tables created', $tables);

        $this->commandBus->dispatch(new SignUpUserCommand('a4033f67-d9d2-4ce8-9943-eeea38316e33', 'a@a.com', '1234'));
    }

    private function countTables(array $metadata): int
    {
        $tables = count($metadata);

        $tables = reduce(
            static function (int $count, ClassMetadata $metadata) {
                $count += count($metadata->associationMappings);

                return $count;
            },
            $metadata,
            $tables
        );

        return $tables;
    }

    private function writeLine(OutputInterface $output, $title, $comment): void
    {
        $output->writeln("<comment>$title:</comment> <info>$comment</info>");
    }
}
