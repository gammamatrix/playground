<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\View\Components\Forms\ColumnSelect;

use Playground\View\Components\Forms\ColumnSelect;
use Tests\Unit\Playground\TestCase;
use Illuminate\Contracts\View\View;

/**
 * \Tests\Unit\Playground\View\Components\Forms\ColumnSelect\ComponentTest
 *
 */
class ComponentTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
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
        $instance = new ColumnSelect();

        $this->assertInstanceOf(ColumnSelect::class, $instance);
    }

    public function test_component_can_render_view_without_parameters()
    {
        $instance = new ColumnSelect();

        $this->assertInstanceOf(View::class, $instance->render());
    }

    public function test_component_can_render_view_with_select()
    {
        $advanced = true;
        $autocomplete = true;
        $class = '';
        $column = 'owned_by_id';
        $instance = new ColumnSelect($advanced, $autocomplete, $class, $column);

        $this->assertInstanceOf(View::class, $instance->render());
    }
}
