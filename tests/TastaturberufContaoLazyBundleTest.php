<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoLazyBundle\Tests;

use PHPUnit\Framework\TestCase;
use Tastaturberuf\ContaoLazyBundle\TastaturberufContaoLazyBundle;

class TastaturberufContaoLazyBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new TastaturberufContaoLazyBundle();

        $this->assertInstanceOf(TastaturberufContaoLazyBundle::class, $bundle);
    }

}
