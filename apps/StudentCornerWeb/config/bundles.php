<?php

declare(strict_types=1);

use Shared\Infrastructure\Symfony\Bundle\SharedBundle;
use StudentCorner\Shared\Infrastructure\Symfony\Bundle\StudentCornerBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;

return [
    SharedBundle::class => ['all' => true],
    StudentCornerBundle::class => ['all' => true],
    FrameworkBundle::class => ['all' => true],
    TwigBundle::class => ['all' => true],
    DebugBundle::class => ['dev' => true],
];
