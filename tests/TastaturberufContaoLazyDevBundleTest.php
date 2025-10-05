<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoLazyDevBundle\Tests;

use PHPUnit\Framework\TestCase;
use Tastaturberuf\ContaoLazyDevBundle\TastaturberufContaoLazyDevBundle;

class TastaturberufContaoLazyDevBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new TastaturberufContaoLazyDevBundle();

        $this->assertInstanceOf(TastaturberufContaoLazyDevBundle::class, $bundle);
    }

}
