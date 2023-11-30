<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Filters\ModelTrait;

use Tests\Unit\GammaMatrix\Playground\TestCase;

/**
 * \Tests\Unit\App\Filter\ModelTrait\AbstractTraitTest
 *
 *
 */
abstract class TraitTestCase extends TestCase
{
    public const TRAIT_CLASS = \GammaMatrix\Playground\Filters\ModelTrait::class;

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
}
