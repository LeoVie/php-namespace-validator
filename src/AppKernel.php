<?php

namespace LeoVie\PhpNf;

use LeoVie\PhpNf\DependencyInjection\CollectCommandsToApplicationCompilerPass;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class AppKernel extends Kernel
{
    /**
     * In more complex app, add bundles here
     */
    public function registerBundles(): array
    {
        return [];
    }

    /**
     * Load all services
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/../config/services.yml');
    }

    protected function build(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addCompilerPass(new CollectCommandsToApplicationCompilerPass());
    }
}