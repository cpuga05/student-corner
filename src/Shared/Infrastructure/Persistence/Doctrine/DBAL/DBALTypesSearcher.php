<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine\DBAL;

use Shared\Domain\Utils;

use function array_flip;
use function array_merge;
use function dump;
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
        return static function (string $path): bool {
            return !empty($path);
        };
    }

    private static function dbalClassesSearcher(string $contextName): callable
    {
        return static function (array $totalNamespaces, string $path) use ($contextName) {
            $possibleFiles = scandir($path);
            $files = filter(
                static function ($file) {
                    return Utils::endsWith('Type.php', $file);
                },
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

            return array_merge($totalNamespaces, $namespaces);
        };
    }
}
