<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoLazyDevBundle\Bundle;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Override;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouteCollection;

abstract class AbstractContaoBundle extends AbstractBundle implements BundlePluginInterface, RoutingPluginInterface
{

    #[Override]
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(static::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class
                ])
        ];
    }

    #[Override]
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $files = glob($this->getPath() . '/config/*.{php,yaml}', GLOB_BRACE);
        $exclude = glob($this->getPath() . '/config/routes.{php,yaml}', GLOB_BRACE);

        foreach ($files as $file) {
            if (in_array($file, $exclude)) {
                continue;
            }

            $container->import($file, ignoreErrors: false);
        }
    }

    #[Override]
    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel): ?RouteCollection
    {
        $files = array_merge(
            glob($this->getPath() . '/config/routes.{php,yaml}', GLOB_BRACE),
            glob($this->getPath() . '/config/routes/*.{php,yaml}', GLOB_BRACE)
        );

        $routeCollection = new RouteCollection();

        foreach ($files as $file) {
            $routeCollection->addCollection($resolver->resolve($file)->load($file));
        }

        return $routeCollection;
    }

}
