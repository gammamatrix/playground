<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\View\Components\PaginationSort;

use Playground\View\Components\PaginationSort;
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
        $sort = [
            'title' => ['label' => 'Title'],
        ];
        // $validated = [];
        // $action = '';
        // $id = '';
        // $sorts = 3;

        $instance = new PaginationSort($sort);

        $this->assertInstanceOf(PaginationSort::class, $instance);
    }

    public function test_component_can_render_view_with_empty_sort()
    {
        $sort = [];
        $validated = [
            'sort' => ['title' , '-active'],
            'perPage' => 1,
            'page' => 1,
        ];
        $instance = new PaginationSort($sort);

        $this->assertInstanceOf(View::class, $instance->render());
    }

    public function test_component_can_render_view_with_invalid_sort()
    {
        // Will fail since array is associative.
        $sort = [
            'title',
        ];
        $validated = [
            'sort' => ['title' , '-active'],
            'perPage' => 1,
            'page' => 1,
        ];
        $instance = new PaginationSort($sort);

        $this->assertInstanceOf(View::class, $instance->render());
    }

    public function test_component_can_render_view()
    {
        $sort = [
            'title' => ['label' => 'Title'],
            'active' => ['label' => 'Active'],
        ];
        $validated = [
            'sort' => ['title' , '-active'],
            'perPage' => 1,
            'page' => 1,
        ];
        $instance = new PaginationSort($sort);

        $this->assertInstanceOf(View::class, $instance->render());
    }
}
