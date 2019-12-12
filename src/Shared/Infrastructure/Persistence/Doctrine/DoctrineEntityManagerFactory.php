<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Shared\Infrastructure\Persistence\Doctrine\DBAL\DBALTypesRegister;
use Shared\Infrastructure\Persistence\Doctrine\DBAL\DBALTypesSearcher;

use function array_merge;

final class DoctrineEntityManagerFactory
{
    private const SHARED_PREFIXES = [
        __DIR__ . '/Mappings' => 'Shared\Domain',
    ];

    public static function create(
        array $parameters,
        array $contextPrefixes,
        bool $isDevMode,
        array $dbalCustomTypesClasses
    ): EntityManagerInterface {
        $dbalCustomTypesClasses = array_merge(
            DBALTypesSearcher::inPath(__DIR__ . '/../../../../../src', 'Shared'),
            $dbalCustomTypesClasses
        );

        DBALTypesRegister::register($dbalCustomTypesClasses);

        $entityManager = EntityManager::create($parameters, self::createConfiguration($contextPrefixes, $isDevMode));

        if ($isDevMode) {
            static::clearData($entityManager);
        }

        return $entityManager;
    }

    private static function clearData(EntityManager $entityManager): void
    {
        $schemaTool = new SchemaTool($entityManager);
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool->updateSchema($metadata, true);
        $schemaTool->getUpdateSchemaSql($metadata, true);
    }

    private static function createConfiguration(array $contextPrefixes, bool $isDevMode): Configuration
    {
        $config = Setup::createConfiguration($isDevMode, null, new ArrayCache());
        $driver = new SimplifiedYamlDriver((array_merge($contextPrefixes, self::SHARED_PREFIXES)));

        $config->setMetadataDriverImpl($driver);

        return $config;
    }
}
