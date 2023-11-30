<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Filters\ModelTrait;

/**
 * \Tests\Unit\GammaMatrix\Playground\Filters\ModelTrait\DateTraitTest
 *
 * @see \GammaMatrix\Playground\Filters\ModelTrait::filterDate()
 * @see \GammaMatrix\Playground\Filters\ModelTrait::filterDateAsCarbon()
 */
class DateTraitTest extends TraitTestCase
{
    /**
     * filterDate
     *
     * @see \GammaMatrix\Playground\Filters\ModelTrait::filterDate()
     */
    public function test_filterDate()
    {
        $this->assertNull($this->mock->filterDate(''));

        $this->assertSame(
            gmdate(config('playground.date.sql', 'Y-m-d H:i:s'), strtotime('now')),
            $this->mock->filterDate('now')
        );

    }

    /**
     * filterDateAsCarbon
     *
     * @see \GammaMatrix\Playground\Filters\ModelTrait::filterDateAsCarbon()
     */
    public function test_filterDateAsCarbon()
    {
        $this->assertNull($this->mock->filterDateAsCarbon(''));

        $date = 'now';
        $this->assertInstanceOf(\DateTime::class, $this->mock->filterDateAsCarbon($date));
        $this->assertInstanceOf(\Carbon\Carbon::class, $this->mock->filterDateAsCarbon($date));
    }
}
