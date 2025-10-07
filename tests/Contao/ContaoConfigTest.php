<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoLazyBundle\Tests\Contao;

use Contao\Model;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tastaturberuf\ContaoLazyBundle\Contao\ContaoConfig;

#[RunTestsInSeparateProcesses]
class ContaoConfigTest extends TestCase
{

    #[Test]
    public function testRegisterModel(): void
    {
        $model = $this->getFooModel();

        $this->assertSame('tl_foo', $model::getTable());

        $this->assertNull($GLOBALS['TL_MODELS']);

        ContaoConfig::registerModel($model::class);

        $this->assertSame($model::class, $GLOBALS['TL_MODELS']['tl_foo']);
    }

    public function testRegisterModelTwice(): void
    {
        $GLOBALS['TL_MODELS']['tl_foo'] = 'someOtherModelClass';

        $model = $this->getFooModel();

        $this->expectException(\InvalidArgumentException::class);

        ContaoConfig::registerModel($model::class);
    }

    public function testForceModelRegistration(): void
    {
        $GLOBALS['TL_MODELS']['tl_foo'] = 'someOtherModelClass';

        $model = $this->getFooModel();

        ContaoConfig::registerModel($model::class, true);

        $this->assertSame($model::class, $GLOBALS['TL_MODELS']['tl_foo']);
    }

    public function testRegisterMultipleModels(): void
    {
        $fooModel = $this->getFooModel();
        $barModel = $this->getBarModel();

        ContaoConfig::registerModels(
            $fooModel::class,
            $barModel::class
        );

        $this->assertSame($fooModel::class, $GLOBALS['TL_MODELS']['tl_foo']);
        $this->assertSame($barModel::class, $GLOBALS['TL_MODELS']['tl_bar']);
    }

    private function getFooModel(): Model
    {
        return new class() extends Model {
            protected static $strTable = 'tl_foo';

            /** @noinspection PhpMissingParentConstructorInspection */
            public function __construct()
            {
            }
        };
    }

    private function getBarModel(): Model
    {
        return new class() extends Model {
            protected static $strTable = 'tl_bar';

            /** @noinspection PhpMissingParentConstructorInspection */
            public function __construct()
            {
            }
        };
    }

}
