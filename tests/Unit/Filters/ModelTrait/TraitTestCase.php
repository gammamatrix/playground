<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Filters\ModelTrait;

use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\App\Filter\ModelTrait\AbstractTraitTest
 */
abstract class TraitTestCase extends TestCase
{
    public const TRAIT_CLASS = \Playground\Filters\ModelTrait::class;

    public $mock;

    /**
     * Setup the test environment.
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
