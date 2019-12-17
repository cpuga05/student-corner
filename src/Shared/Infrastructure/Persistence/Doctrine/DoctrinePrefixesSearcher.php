<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine;

use Shared\Domain\Utils;

use function array_flip;
use function Lambdish\Phunctional\filter;
use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reindex;
use function realpath;

final class DoctrinePrefixesSearcher
{
    private const MAPPINGS_PATH = 'Infrastructure/Persistence/Doctrine/Mappings';

    public static function inPath(string $path, string $baseNamespace): array
    {
        $possibleMappingDirectories = self::possibleMappingDirectories($path);
        $mappingDirectories = filter(self::isExistingMappingPath(), $possibleMappingDirectories);

        return array_flip(reindex(self::namespaceFormatter($baseNamespace), $mappingDirectories));
    }

    private static function possibleMappingDirectories(string $path): array
    {
        return map(
            static function ($unused, string $module) use ($path) {
                $mappingsPath = self::MAPPINGS_PATH;

                return realpath("$path/$module/$mappingsPath");
            },
            array_flip(Utils::directoriesIn($path))
        );
    }

    private static function isExistingMappingPath(): callable
    {
        return fn(string $path): bool => !empty($path);
    }

    private static function namespaceFormatter(string $baseNamespace): callable
    {
        return fn(string $path, string $module): string => "$baseNamespace\\$module\Domain";
    }
}
