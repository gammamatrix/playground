<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Filters\ModelTrait;

/**
 * \Tests\Unit\GammaMatrix\Playground\Filters\ModelTrait\BitsTraitTest
 *
 * @see \GammaMatrix\Playground\Filters\ModelTrait::filterBits()
 * @see \GammaMatrix\Playground\Filters\ModelTrait::filterBits()
 */
class BitsTraitTest extends TraitTestCase
{
    /**
     * filterBits: $exponent = 0
     *
     * @see \GammaMatrix\Playground\Filters\ModelTrait::filterBits()
     */
    public function test_filterBits_for_exponent_zero()
    {
        $this->assertSame(0, $this->mock->filterBits(0));

        $value = 1 + 2 + 4 + 8 + 16 + 32;
        $expected = 1;
        $this->assertSame($expected, $this->mock->filterBits($value));
    }

    /**
     * filterBits: $exponent > 0
     *
     * @see \GammaMatrix\Playground\Filters\ModelTrait::filterBits()
     */
    public function test_filterBits_for_exponent_greater_than_zero()
    {
        $value = 1 + 2 + 4 + 8 + 16 + 32;

        $exponent = 1;
        $expected = 1 + 2;
        $this->assertSame($expected, $this->mock->filterBits($value, $exponent));

        $exponent = 2;
        $expected = 1 + 2 + 4;
        $this->assertSame($expected, $this->mock->filterBits($value, $exponent));

        $exponent = 3;
        $expected = 1 + 2 + 4 + 8;
        $this->assertSame($expected, $this->mock->filterBits($value, $exponent));

        $exponent = 4;
        $expected = 1 + 2 + 4 + 8 + 16;
        $this->assertSame($expected, $this->mock->filterBits($value, $exponent));

        $exponent = 5;
        $expected = 1 + 2 + 4 + 8 + 16 + 32;
        $this->assertSame($expected, $this->mock->filterBits($value, $exponent));
    }
}
