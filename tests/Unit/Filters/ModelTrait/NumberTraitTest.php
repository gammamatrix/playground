<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Filters\ModelTrait;

/**
 * \Tests\Unit\GammaMatrix\Playground\Filters\ModelTrait\NumberTraitTest
 *
 * @see \GammaMatrix\Playground\Filters\ModelTrait::filterBits()
 * @see \GammaMatrix\Playground\Filters\ModelTrait::filterBits()
 */
class NumberTraitTest extends TraitTestCase
{
    /**
     * filterFloat
     *
     * @see \GammaMatrix\Playground\Filters\ModelTrait::filterFloat()
     */
    public function test_filterFloat()
    {
        $this->assertNull($this->mock->filterFloat(''));
        $this->assertNull($this->mock->filterFloat(null));

        $this->assertSame(0.0, $this->mock->filterFloat(0));
        $this->assertSame(1.0, $this->mock->filterFloat(1));
    }

    /**
     * filterInteger
     *
     * @see \GammaMatrix\Playground\Filters\ModelTrait::filterInteger()
     */
    public function test_filterInteger()
    {
        $this->assertSame(0, $this->mock->filterInteger(''));
        $this->assertSame(0, $this->mock->filterInteger(null));
        $this->assertSame(0, $this->mock->filterInteger(false));

        $this->assertSame(1000, $this->mock->filterInteger('1,000'));
        $this->assertSame(2000, $this->mock->filterInteger('2,000.01'));
        $this->assertSame(0, $this->mock->filterInteger(0));
        $this->assertSame(1, $this->mock->filterInteger(1));
        $this->assertSame(-1001, $this->mock->filterInteger(-1001));
    }

    /**
     * filterIntegerId
     *
     * @see \GammaMatrix\Playground\Filters\ModelTrait::filterIntegerId()
     */
    public function test_filterIntegerId()
    {
        $this->assertNull($this->mock->filterIntegerId(''));
        $this->assertNull($this->mock->filterIntegerId(null));
        $this->assertNull($this->mock->filterIntegerId(false));

        $this->assertNull($this->mock->filterIntegerId('1,000'));
        $this->assertNull($this->mock->filterIntegerId('2,000.01'));
        $this->assertNull($this->mock->filterIntegerId(0));
        $this->assertSame(1, $this->mock->filterIntegerId(1));
        $this->assertNull($this->mock->filterIntegerId(-1001));
        $this->assertNull($this->mock->filterIntegerId('-1001'));
        $this->assertSame(1, $this->mock->filterIntegerId('1'));
        $this->assertSame(100, $this->mock->filterIntegerId('100'));
        $this->assertSame(2000000, $this->mock->filterIntegerId('2000000.0'));
    }

    /**
     * filterIntegerPositive
     *
     * @see \GammaMatrix\Playground\Filters\ModelTrait::filterIntegerPositive()
     */
    public function test_filterIntegerPositive()
    {
        $this->assertSame(0, $this->mock->filterIntegerPositive(''));
        $this->assertSame(0, $this->mock->filterIntegerPositive(null));
        $this->assertSame(0, $this->mock->filterIntegerPositive(false));

        $this->assertSame(1, $this->mock->filterIntegerPositive('1,000'));
        $this->assertSame(2, $this->mock->filterIntegerPositive('2,000.01'));
        $this->assertSame(0, $this->mock->filterIntegerPositive(0));
        $this->assertSame(1, $this->mock->filterIntegerPositive(1));
        $this->assertSame(1001, $this->mock->filterIntegerPositive(-1001));
        $this->assertSame(1001, $this->mock->filterIntegerPositive(-1001));

        $absolute = true;
        $this->assertSame(0, $this->mock->filterIntegerPositive('', $absolute));
        $this->assertSame(0, $this->mock->filterIntegerPositive(null, $absolute));
        $this->assertSame(0, $this->mock->filterIntegerPositive(false, $absolute));

        $this->assertSame(1, $this->mock->filterIntegerPositive('1,000', $absolute));
        $this->assertSame(2, $this->mock->filterIntegerPositive('2,000.01', $absolute));
        $this->assertSame(0, $this->mock->filterIntegerPositive(0, $absolute));
        $this->assertSame(1, $this->mock->filterIntegerPositive(1, $absolute));
        $this->assertSame(1001, $this->mock->filterIntegerPositive(-1001, $absolute));
        $this->assertSame(1001, $this->mock->filterIntegerPositive(-1001, $absolute));

        $absolute = false;
        $this->assertSame(0, $this->mock->filterIntegerPositive('', $absolute));
        $this->assertSame(0, $this->mock->filterIntegerPositive(null, $absolute));
        $this->assertSame(0, $this->mock->filterIntegerPositive(false, $absolute));

        $this->assertSame(1, $this->mock->filterIntegerPositive('1,000', $absolute));
        $this->assertSame(2, $this->mock->filterIntegerPositive('2,000.01', $absolute));
        $this->assertSame(0, $this->mock->filterIntegerPositive(0, $absolute));
        $this->assertSame(1, $this->mock->filterIntegerPositive(1, $absolute));
        $this->assertSame(-1001, $this->mock->filterIntegerPositive(-1001, $absolute));
        $this->assertSame(-1001, $this->mock->filterIntegerPositive(-1001, $absolute));
    }

    /**
     * filterPercent
     *
     * @see \GammaMatrix\Playground\Filters\ModelTrait::filterPercent()
     */
    public function test_filterPercent()
    {
        $this->assertNull($this->mock->filterPercent(''));
        $this->assertNull($this->mock->filterPercent(null));
        $this->assertNull($this->mock->filterPercent(false));

        $this->assertSame(1000.0, $this->mock->filterPercent('1,000%'));

        $this->assertSame(1000.0, $this->mock->filterPercent('1,000'));
        $this->assertSame(2000.01, $this->mock->filterPercent('2,000.01'));
        $this->assertSame(0.0, $this->mock->filterPercent(0));
        $this->assertSame(1.0, $this->mock->filterPercent(1));
        $this->assertSame(-1001.0, $this->mock->filterPercent('-1001 %'));
    }
}
