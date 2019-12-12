<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine\DBAL;

interface DoctrineCustomType
{
    public static function customTypeName(): string;
}
