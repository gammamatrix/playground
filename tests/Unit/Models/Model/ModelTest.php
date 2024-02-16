<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use PHPUnit\Framework\MockObject\MockObject;
use Playground\Models\Model as TestModel;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Models\Model\ModelTest
 */
class ModelTest extends TestCase
{
    /**
     * @var class-string
     */
    public const MODEL_CLASS = TestModel::class;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        if (! class_exists(static::MODEL_CLASS)) {
            $this->markTestSkipped(sprintf(
                'Expecting the abstract this->mock class to exist: %1$s',
                static::MODEL_CLASS
            ));
        }
        config(['auth.providers.users.model' => \Playground\Test\Models\User::class]);
    }

    public function test_WithChildren_children_returns_HasMany(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $this->assertInstanceOf(HasMany::class, $mock->children());
    }

    public function test_WithCreator_creator_returns_HasOne(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $this->assertInstanceOf(HasOne::class, $mock->creator());
    }

    public function test_WithModifier_modifier_returns_HasOne(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $this->assertInstanceOf(HasOne::class, $mock->modifier());
    }

    public function test_WithOwner_owner_returns_HasOne(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $this->assertInstanceOf(HasOne::class, $mock->owner());
    }

    public function test_WithParent_parent_returns_HasOne(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $this->assertInstanceOf(HasOne::class, $mock->parent());
    }
}
