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
use function file_exists;

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
        if (file_exists($file = $this->getPath() . '/config/services.php')) {
            $container->import($file);
        }
    }

    #[Override]
    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel): ?RouteCollection
    {
        if (file_exists($file = $this->getPath() . '/config/routes.php')) {
            return $resolver
                ->resolve($file)
                ->load($file);
        }

        return null;
    }

}
