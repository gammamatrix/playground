<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Filters\ModelTrait;

use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Filters\ModelTrait\ValueTraitTest
 *
 * @see \Playground\Filters\ModelTrait::filterBoolean()
 * @see \Playground\Filters\ModelTrait::filterFloat()
 * @see \Playground\Filters\ModelTrait::filterInteger()
 * @see \Playground\Filters\ModelTrait::filterPercent()
 */
class ValueTraitTest extends TestCase
{
    /**
     * filterBoolean
     *
     * @see \Playground\Filters\ModelTrait::filterBoolean()
     */
    public function test_filterBoolean(): void
    {
        $instance = new FilterModel;

        // Always return an array, no matter the input.

        // empty array
        $this->assertFalse($instance->filterBoolean([]));

        // NULL
        $this->assertFalse($instance->filterBoolean(null));

        // false
        $this->assertFalse($instance->filterBoolean([]));

        // true
        $this->assertTrue($instance->filterBoolean(true));

        // Positive numbers are true
        $this->assertTrue($instance->filterBoolean(10));
        $this->assertTrue($instance->filterBoolean(1));
        $this->assertFalse($instance->filterBoolean(0));
        $this->assertFalse($instance->filterBoolean(-10));

        // Empty string
        $this->assertFalse($instance->filterBoolean(''));

        $this->assertTrue($instance->filterBoolean('true'));

        $this->assertFalse($instance->filterBoolean('not-true'));

        $value = [
            'i' => 'am-a-test-array',
            'someNullValue' => null,
            'aString' => 'thanks!',
            'object' => (object) ['ok' => true],
        ];

        $this->assertTrue($instance->filterBoolean($value));
    }

    /**
     * filterEmail
     *
     * @see \Playground\Filters\ModelTrait::filterEmail()
     */
    public function test_filterEmail(): void
    {
        $instance = new FilterModel;

        $value = false;
        $this->assertSame('', $instance->filterEmail($value));

        $value = 'not valid email with spaces @ example.com';
        $this->assertSame('notvalidemailwithspaces@example.com', $instance->filterEmail($value));

        $value = 'test@';
        $this->assertSame($value, $instance->filterEmail($value));

        $value = 'test@example.com';
        $this->assertSame($value, $instance->filterEmail($value));
        $value = '<test@example.com>';
        $this->assertSame('test@example.com', $instance->filterEmail($value));

        $value = 'test+with.plus-addressing@example.com';
        $this->assertSame($value, $instance->filterEmail($value));
    }

    /**
     * filterHtml
     *
     * @see \Playground\Filters\ContentTrait::purify() HTMLPurifier
     * @see \Playground\Filters\ModelTrait::filterHtml()
     */
    public function test_filterHtml(): void
    {
        $instance = new FilterModel;

        $value = '<b>Tags should be removed.</b>';
        $this->assertSame('Tags should be removed.', $instance->filterHtml($value));

        $value = '<a href="https://google.com">No links allowed either.</a>';
        $this->assertSame('No links allowed either.', $instance->filterHtml($value));
    }
}
