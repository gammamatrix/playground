<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Filters\ModelTrait;

use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Filters\ModelTrait\BitsTraitTest
 *
 * @see \Playground\Filters\ModelTrait::filterBits()
 * @see \Playground\Filters\ModelTrait::filterBits()
 */
class BitsTraitTest extends TestCase
{
    /**
     * filterBits: $exponent = 0
     *
     * @see \Playground\Filters\ModelTrait::filterBits()
     */
    public function test_filterBits_for_exponent_zero(): void
    {
        $instance = new FilterModel;

        $this->assertSame(0, $instance->filterBits(0));

        $value = 1 + 2 + 4 + 8 + 16 + 32;
        $expected = 1;
        $this->assertSame($expected, $instance->filterBits($value));
    }

    /**
     * filterBits: $exponent > 0
     *
     * @see \Playground\Filters\ModelTrait::filterBits()
     */
    public function test_filterBits_for_exponent_greater_than_zero(): void
    {
        $instance = new FilterModel;

        $value = 1 + 2 + 4 + 8 + 16 + 32;

        $exponent = 1;
        $expected = 1 + 2;
        $this->assertSame($expected, $instance->filterBits($value, $exponent));

        $exponent = 2;
        $expected = 1 + 2 + 4;
        $this->assertSame($expected, $instance->filterBits($value, $exponent));

        $exponent = 3;
        $expected = 1 + 2 + 4 + 8;
        $this->assertSame($expected, $instance->filterBits($value, $exponent));

        $exponent = 4;
        $expected = 1 + 2 + 4 + 8 + 16;
        $this->assertSame($expected, $instance->filterBits($value, $exponent));

        $exponent = 5;
        $expected = 1 + 2 + 4 + 8 + 16 + 32;
        $this->assertSame($expected, $instance->filterBits($value, $exponent));
    }
}