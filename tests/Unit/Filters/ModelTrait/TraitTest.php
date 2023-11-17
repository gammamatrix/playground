<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Filters\ModelTrait;

use GammaMatrix\Playground\Test\TestCase;

/**
 * \Tests\Unit\Playground\Filters\ModelTrait\TraitTest
 *
 */
class TraitTest extends TestCase
{
    /**
     * @var string
     */
    const TRAIT_CLASS = \GammaMatrix\Playground\Filters\ModelTrait::class;

    /**
     * @var object
     */
    public $mock;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = $this->getMockForTrait(
            static::TRAIT_CLASS,
            [],
            '',
            true,
            true,
            true,
            $methods = []
        );
    }

    /**
     * Test filterArray().
     *
     */
    public function test_filterArray()
    {
        $expected = ['some-string'];

        $this->assertSame($expected, $this->mock->filterArray($expected));
    }

    /**
     * Test filterArray().
     *
     */
    public function test_filterArray_with_string()
    {
        $expected = 'some-string';

        $this->assertSame([$expected], $this->mock->filterArray($expected));
    }

    /**
     * Test filterArray().
     *
     */
    public function test_filterArray_with_null()
    {
        $expected = [];

        $this->assertSame($expected, $this->mock->filterArray(null));
    }
}

