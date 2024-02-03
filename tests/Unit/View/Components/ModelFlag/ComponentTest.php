<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\View\Components\ModelFlag;

use Illuminate\Contracts\View\View;
use Playground\View\Components\ModelFlag;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\View\Components\Table\ComponentTest
 */
class ComponentTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'playground.load.views' => true,
        ]);
    }

    public function test_component_instance()
    {
        $columnMeta = [];
        $value = null;
        $instance = new ModelFlag($columnMeta, $value);

        $this->assertInstanceOf(ModelFlag::class, $instance);
    }

    public function test_component_can_render_view_with_null_value()
    {
        $columnMeta = [
            'onFalseClass' => '',
            'onFalseLabel' => '',
            'onTrueClass' => '',
            'onTrueLabel' => '',
        ];
        $value = null;
        $instance = new ModelFlag($columnMeta, $value);

        $this->assertInstanceOf(View::class, $instance->render());
    }

    public function test_component_can_render_view_with_true_value()
    {
        $columnMeta = [
            'onFalseClass' => 'fa-solid fa-user',
            'onFalseLabel' => 'Civilian',
            'onTrueClass' => 'fa-solid fa-user-secret',
            'onTrueLabel' => 'Spy',
        ];
        $value = true;
        $instance = new ModelFlag($columnMeta, $value);

        $this->assertInstanceOf(View::class, $instance->render());
    }

    public function test_component_can_render_view_with_false_value()
    {
        $columnMeta = [
            'onFalseClass' => 'fa-solid fa-user',
            'onFalseLabel' => 'Civilian',
            'onTrueClass' => 'fa-solid fa-user-secret',
            'onTrueLabel' => 'Spy',
        ];
        $value = false;
        $instance = new ModelFlag($columnMeta, $value);

        $this->assertInstanceOf(View::class, $instance->render());
    }
}
