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
    public function test_with_children_children_returns_has_many(): void
    {
        $instance = new TestModel;

        $this->assertInstanceOf(HasMany::class, $instance->children());
    }

    public function test_with_creator_creator_returns_has_one(): void
    {
        $instance = new TestModel;

        $this->assertInstanceOf(HasOne::class, $instance->creator());
    }

    public function test_with_modifier_modifier_returns_has_one(): void
    {
        $instance = new TestModel;

        $this->assertInstanceOf(HasOne::class, $instance->modifier());
    }

    public function test_with_owner_owner_returns_has_one(): void
    {
        $instance = new TestModel;

        $this->assertInstanceOf(HasOne::class, $instance->owner());
    }

    public function test_with_parent_parent_returns_has_one(): void
    {
        $instance = new TestModel;

        $this->assertInstanceOf(HasOne::class, $instance->parent());
    }
}
