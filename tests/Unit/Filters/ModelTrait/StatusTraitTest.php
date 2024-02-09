<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Filters\ModelTrait;

use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Filters\ModelTrait\DateTraitTest
 *
 * @see \Playground\Filters\ModelTrait::filterStatus()
 */
class StatusTraitTest extends TestCase
{
    /**
     * filterStatus
     *
     * @see \Playground\Filters\ModelTrait::filterStatus()
     */
    public function test_filterStatus(): void
    {
        $instance = new FilterModel;

        $this->assertSame([], $instance->filterStatus([]));

        $expected = ['status' => 1];
        $this->assertSame($expected, $instance->filterStatus(['status' => 1]));
        $this->assertSame($expected, $instance->filterStatus(['status' => '1']));
        $this->assertSame($expected, $instance->filterStatus(['status' => '-1.0']));

        $expected = [
            'status' => [
                'active' => true,
                'lock' => true,
                'public' => false,
            ],
        ];
        $this->assertSame($expected, $instance->filterStatus([
            'status' => [
                'active' => 1,
                'lock' => true,
                'public' => 0,
            ],
        ]));
    }
}
