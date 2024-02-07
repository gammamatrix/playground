<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Models\Model\ModelTest
 */
class ModelTest extends TestCase
{
    /**
     * @var string
     */
    public const ABSTRACT_CLASS = \Playground\Models\Model::class;

    /**
     * @var object&\Playground\Models\Model::class
     */
    public $mock;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        if (! class_exists(static::ABSTRACT_CLASS)) {
            $this->markTestSkipped(sprintf(
                'Expecting the abstract this->mock class to exist: %1$s',
                static::ABSTRACT_CLASS
            ));
        }
        $this->mock = $this->getMockForAbstractClass(static::ABSTRACT_CLASS);
        config(['playground.user' => \Playground\Test\Models\User::class]);
    }

    public function test_WithChildren_children_returns_HasMany(): void
    {
        $this->assertInstanceOf(HasMany::class, $this->mock->children());
    }

    public function test_WithCreator_creator_returns_HasOne(): void
    {
        $this->assertInstanceOf(HasOne::class, $this->mock->creator());
    }

    public function test_WithModifier_modifier_returns_HasOne(): void
    {
        $this->assertInstanceOf(HasOne::class, $this->mock->modifier());
    }

    public function test_WithOwner_owner_returns_HasOne(): void
    {
        $this->assertInstanceOf(HasOne::class, $this->mock->owner());
    }

    public function test_WithParent_parent_returns_HasOne(): void
    {
        $this->assertInstanceOf(HasOne::class, $this->mock->parent());
    }
}
