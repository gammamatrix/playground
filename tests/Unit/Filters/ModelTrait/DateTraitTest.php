<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Filters\ModelTrait;

/**
 * \Tests\Unit\Playground\Filters\ModelTrait\DateTraitTest
 *
 * @see \Playground\Filters\ModelTrait::filterDate()
 * @see \Playground\Filters\ModelTrait::filterDateAsCarbon()
 */
class DateTraitTest extends TraitTestCase
{
    /**
     * filterDate
     *
     * @see \Playground\Filters\ModelTrait::filterDate()
     */
    public function test_filterDate(): void
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
     * @see \Playground\Filters\ModelTrait::filterDateAsCarbon()
     */
    public function test_filterDateAsCarbon(): void
    {
        $this->assertNull($this->mock->filterDateAsCarbon(''));

        $date = 'now';
        $this->assertInstanceOf(\DateTime::class, $this->mock->filterDateAsCarbon($date));
        $this->assertInstanceOf(\Carbon\Carbon::class, $this->mock->filterDateAsCarbon($date));
    }
}
