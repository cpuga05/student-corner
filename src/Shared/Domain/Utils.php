<?php

declare(strict_types=1);

namespace Shared\Domain;

use DateTimeInterface;
use RuntimeException;

use function array_filter;
use function ctype_lower;
use function in_array;
use function is_array;
use function json_decode;
use function json_encode;
use function json_last_error;
use function lcfirst;
use function preg_replace;
use function scandir;
use function str_replace;
use function strlen;
use function strtolower;
use function ucwords;

use const JSON_ERROR_NONE;

final class Utils
{
    public static function endsWith(string $needle, string $haystack): bool
    {
        $length = strlen($needle);

        if (0 === $length) {
            return true;
        }

        return substr($haystack, -$length) === $needle;
    }

    public static function dateToString(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }

    public static function jsonEncode(array $values): string
    {
        return json_encode($values);
    }

    public static function jsonDecode(string $json): array
    {
        $data = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException('Unable to parse response body into JSON: ' . json_last_error());
        }

        return $data;
    }

    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text) ? $text : strtolower(preg_replace('`([^A-Z\s])([A-Z])`', '$1_$2', $text));
    }

    public static function toCameCase(string $text): string
    {
        return lcfirst(str_replace('_', '', ucwords(strtolower($text), '_')));
    }

    public static function dot(array $items, string $prepend = ''): array
    {
        $results = [];

        foreach ($items as $key => $item) {
            if (is_array($item) && !empty($item)) {
                $results = [...$results, ...static::dot($item, $prepend . $key . '.')];
            } else {
                $results[$prepend . $key] = $item;
            }
        }

        return $results;
    }

    public static function directoriesIn(string $path): array
    {
        return array_filter(
            scandir($path),
            fn(string $folder) => !in_array($folder, ['.', '..'])
        );
    }

    public static function filesIn(string $path, string $fileType): array
    {
        return array_filter(
            scandir($path),
            fn(string $file) => strstr($file, $fileType)
        );
    }
}
