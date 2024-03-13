<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\Unit\Playground\Models\TestModel;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Models\Model\ModelTest
 */
class ModelTest extends TestCase
{
    public function test_WithChildren_children_returns_HasMany(): void
    {
        $instance = new TestModel;

        $this->assertInstanceOf(HasMany::class, $instance->children());
    }

    public function test_WithCreator_creator_returns_HasOne(): void
    {
        $instance = new TestModel;

        $this->assertInstanceOf(HasOne::class, $instance->creator());
    }

    public function test_WithModifier_modifier_returns_HasOne(): void
    {
        $instance = new TestModel;

        $this->assertInstanceOf(HasOne::class, $instance->modifier());
    }

    public function test_WithOwner_owner_returns_HasOne(): void
    {
        $instance = new TestModel;

        $this->assertInstanceOf(HasOne::class, $instance->owner());
    }

    public function test_WithParent_parent_returns_HasOne(): void
    {
        $instance = new TestModel;

        $this->assertInstanceOf(HasOne::class, $instance->parent());
    }
}
