<?php

declare(strict_types=1);

namespace StudentCorner\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Shared\Infrastructure\Persistence\Doctrine\DBAL\DBALTypesSearcher;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineEntityManagerFactory;
use Shared\Infrastructure\Persistence\Doctrine\DoctrinePrefixesSearcher;

use function dump;

final class StudentCornerEntityManagerFactory
{
    public static function create(array $parameters, string $environment): EntityManagerInterface
    {
        $isDevMode = 'prod' !== $environment;
        $prefixes = DoctrinePrefixesSearcher::inPath(__DIR__ . '/../../../../../StudentCorner', 'StudentCorner');
        $dbalCustomTypesClasses = DBALTypesSearcher::inPath(__DIR__ . '/../../../../../StudentCorner', 'StudentCorner');

        return DoctrineEntityManagerFactory::create($parameters, $prefixes, $isDevMode, $dbalCustomTypesClasses);
    }
}
