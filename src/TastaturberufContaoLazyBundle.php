<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoLazyBundle;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Override;
use Tastaturberuf\ContaoLazyBundle\Bundle\LazyBundle;


final class TastaturberufContaoLazyBundle extends LazyBundle
{

    /**
     * This bundle can't be in the setLoadAfter() of the parent class. It can't be loaded before itself.
     */
    #[Override]
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(static::class)
                ->setLoadAfter([ContaoCoreBundle::class])
        ];
    }
}
