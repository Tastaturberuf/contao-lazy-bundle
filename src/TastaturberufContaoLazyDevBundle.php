<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoLazyDevBundle;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Override;
use Tastaturberuf\ContaoLazyDevBundle\Bundle\AbstractContaoBundle;


final class TastaturberufContaoLazyDevBundle extends AbstractContaoBundle
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
