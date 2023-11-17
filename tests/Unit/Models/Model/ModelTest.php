<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Models\Model;

use GammaMatrix\Playground\Test\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Tests\Unit\GammaMatrix\Playground\Models\Model\ModelTest
 *
 */
class ModelTest extends TestCase
{
    /**
     * @var string
     */
    const ABSTRACT_CLASS = \GammaMatrix\Playground\Models\Model::class;

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

        if (!class_exists(static::ABSTRACT_CLASS)) {
            $this->markTestSkipped(sprintf(
                'Expecting the abstract model class to exist: %1$s',
                static::ABSTRACT_CLASS
            ));
        }

        $this->mock = $this->getMockForAbstractClass(static::ABSTRACT_CLASS);
    }

    public function test_WithChildren_children_returns_HasMany()
    {
        $this->assertInstanceOf(HasMany::class, $this->mock->children());
    }

    public function test_WithCreator_creator_returns_HasOne()
    {
        $this->assertInstanceOf(HasOne::class, $this->mock->creator());
    }

    public function test_WithModifier_modifier_returns_HasOne()
    {
        $this->assertInstanceOf(HasOne::class, $this->mock->modifier());
    }

    public function test_WithOwner_owner_returns_HasOne()
    {
        $this->assertInstanceOf(HasOne::class, $this->mock->owner());
    }

    public function test_WithParent_parent_returns_HasOne()
    {
        $this->assertInstanceOf(HasOne::class, $this->mock->parent());
    }
}

