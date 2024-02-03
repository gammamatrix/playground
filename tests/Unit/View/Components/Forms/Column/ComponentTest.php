<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\View\Components\Forms\Column;

use Illuminate\Contracts\View\View;
use Playground\View\Components\Forms\Column;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\View\Components\Forms\Column\ComponentTest
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
        $instance = new Column();

        $this->assertInstanceOf(Column::class, $instance);
    }

    public function test_component_can_render_view_without_parameters()
    {
        $instance = new Column();

        $this->assertInstanceOf(View::class, $instance->render());
    }

    public function test_component_can_render_view_with_label_input()
    {
        $advanced = true;
        $autocomplete = null;
        $column = 'label';
        $instance = new Column($advanced, $autocomplete, $column);

        $this->assertInstanceOf(View::class, $instance->render());
    }
}
