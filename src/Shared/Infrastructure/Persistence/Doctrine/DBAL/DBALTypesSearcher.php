<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine\DBAL;

use Shared\Domain\Utils;

use function array_flip;
use function explode;
use function Lambdish\Phunctional\filter;
use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reduce;
use function realpath;
use function scandir;
use function str_replace;

final class DBALTypesSearcher
{
    private const TYPES_PATH = 'Infrastructure/Persistence/Doctrine/Types';

    public static function inPath(string $path, string $contextName): array
    {
        $possibleDbalDirectories = self::possibleDbalPaths($path);
        $dbalDirectories = filter(self::isExistingDbalPath(), $possibleDbalDirectories);

        return reduce(self::dbalClassesSearcher($contextName), $dbalDirectories, []);
    }

    private static function possibleDbalPaths(string $path): array
    {
        return map(
            static function ($unused, string $module) use ($path) {
                $typesPath = self::TYPES_PATH;

                return realpath("$path/$module/$typesPath");
            },
            array_flip(Utils::directoriesIn($path))
        );
    }

    private static function isExistingDbalPath(): callable
    {
        return fn(string $path): bool => !empty($path);
    }

    private static function dbalClassesSearcher(string $contextName): callable
    {
        return static function (array $totalNamespaces, string $path) use ($contextName) {
            $possibleFiles = scandir($path);
            $files = filter(
                fn($file) => Utils::endsWith('Type.php', $file),
                $possibleFiles
            );

            $namespaces = map(
                static function (string $file) use ($path, $contextName) {
                    $fullPath = "$path/$file";
                    $splitterPath = explode("/src/$contextName/", $fullPath);

                    $classWithoutPrefix = str_replace(['.php', '/'], ['', '\\'], $splitterPath[1]);

                    return "$contextName\\$classWithoutPrefix";
                },
                $files
            );

            return [...$totalNamespaces, ...$namespaces];
        };
    }
}
