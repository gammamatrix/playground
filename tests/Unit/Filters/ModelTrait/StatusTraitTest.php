<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\Filters\ModelTrait;

/**
 * \Tests\Unit\Playground\Filters\ModelTrait\DateTraitTest
 *
 * @see \Playground\Filters\ModelTrait::filterStatus()
 */
class StatusTraitTest extends TraitTestCase
{
    /**
     * filterStatus
     *
     * @see \Playground\Filters\ModelTrait::filterStatus()
     */
    public function test_filterStatus()
    {
        $this->assertSame([], $this->mock->filterStatus([]));

        $expected = ['status' => 1];
        $this->assertSame($expected, $this->mock->filterStatus(['status' => 1]));
        $this->assertSame($expected, $this->mock->filterStatus(['status' => '1']));
        $this->assertSame($expected, $this->mock->filterStatus(['status' => '-1.0']));

        $expected = [
            'status' => [
                'active' => true,
                'lock' => true,
                'public' => false,
            ],
        ];
        $this->assertSame($expected, $this->mock->filterStatus([
            'status' => [
                'active' => 1,
                'lock' => true,
                'public' => 0,
            ],
        ]));
    }
}
