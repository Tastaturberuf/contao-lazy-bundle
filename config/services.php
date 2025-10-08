<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Tastaturberuf\ContaoLazyBundle\DataContainer\LazyAliasGenerator;
use Tastaturberuf\ContaoLazyBundle\Monolog\LazyContaoLogger;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

/**
 * @Formatter:off
 */
return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->defaults()
            ->autowire()
            ->autoconfigure();

        ->set(LazyAliasGenerator::class)
        ->args([
            '$slug' => service('contao.slug'),
            '$connection' => service('doctrine.dbal.default_connection'),
        ])
    ;
};
