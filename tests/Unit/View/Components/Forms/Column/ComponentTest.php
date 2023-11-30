<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\View\Components\Forms\Column;

use GammaMatrix\Playground\View\Components\Forms\Column;
use Tests\Unit\GammaMatrix\Playground\TestCase;
use Illuminate\Contracts\View\View;

/**
 * \Tests\Unit\GammaMatrix\Playground\View\Components\Forms\Column\ComponentTest
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
