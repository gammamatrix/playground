<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\View\Components\Table\Data;

use Playground\View\Components\Table\Data as DataTable;
use Tests\Unit\Playground\TestCase;
use Illuminate\Contracts\View\View;

/**
 * \Tests\Unit\Playground\View\Components\Table\ComponentTest
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
        $instance = new DataTable();

        $this->assertInstanceOf(DataTable::class, $instance);
    }

    public function test_component_can_render_view()
    {
        $instance = new DataTable();

        $this->assertInstanceOf(View::class, $instance->render());
    }
}
