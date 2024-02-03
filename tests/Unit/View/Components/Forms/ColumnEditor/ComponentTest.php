<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\View\Components\Forms\ColumnEditor;

use Illuminate\Contracts\View\View;
use Playground\View\Components\Forms\ColumnEditor;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\View\Components\Forms\ColumnEditor\ComponentTest
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
        $instance = new ColumnEditor();

        $this->assertInstanceOf(ColumnEditor::class, $instance);
    }

    public function test_component_can_render_view_without_parameters()
    {
        $instance = new ColumnEditor();

        $this->assertInstanceOf(View::class, $instance->render());
    }

    public function test_component_can_render_view_with_content_textarea()
    {
        $advanced = true;
        $class = 'editor';
        $column = 'content';
        $instance = new ColumnEditor($advanced, $class, $column);

        $this->assertInstanceOf(View::class, $instance->render());
    }
}
