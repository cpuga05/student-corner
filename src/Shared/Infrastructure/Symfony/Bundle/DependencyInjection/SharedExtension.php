<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class SharedExtension extends Extension
{
    public function load(
        array $config,
        ContainerBuilder $container
    ): void {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/Resources'));

        $loader->load('infrastructure_extension.yaml');
        $loader->load('infrastructure_config.yaml');
    }
}
