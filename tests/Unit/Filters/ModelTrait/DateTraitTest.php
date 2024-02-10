<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Filters\ModelTrait;

use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Filters\ModelTrait\DateTraitTest
 *
 * @see \Playground\Filters\ModelTrait::filterDate()
 * @see \Playground\Filters\ModelTrait::filterDateAsCarbon()
 */
class DateTraitTest extends TestCase
{
    /**
     * filterDate
     *
     * @see \Playground\Filters\ModelTrait::filterDate()
     */
    public function test_filterDate(): void
    {
        $instance = new FilterModel;

        $this->assertNull($instance->filterDate(''));

        $PLAYGROUND_DATE_SQL = config('playground.date.sql');

        if (! $PLAYGROUND_DATE_SQL || ! is_string($PLAYGROUND_DATE_SQL)) {
            throw new \Exception('Expecting PLAYGROUND_DATE_SQL to be a string.');
        }

        $this->assertSame(
            gmdate($PLAYGROUND_DATE_SQL, strtotime('now')),
            $instance->filterDate('now')
        );
    }

    /**
     * filterDateAsCarbon
     *
     * @see \Playground\Filters\ModelTrait::filterDateAsCarbon()
     */
    public function test_filterDateAsCarbon(): void
    {
        $instance = new FilterModel;

        $this->assertNull($instance->filterDateAsCarbon(''));

        $date = 'now';
        $this->assertInstanceOf(\DateTime::class, $instance->filterDateAsCarbon($date));
        $this->assertInstanceOf(\Carbon\Carbon::class, $instance->filterDateAsCarbon($date));
    }
}
