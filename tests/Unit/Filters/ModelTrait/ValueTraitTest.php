<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Filters\ModelTrait;

/**
 * \Tests\Unit\GammaMatrix\Playground\Filters\ModelTrait\ValueTraitTest
 *
 * @see \GammaMatrix\Playground\Filters\ModelTrait::filterBoolean()
 * @see \GammaMatrix\Playground\Filters\ModelTrait::filterFloat()
 * @see \GammaMatrix\Playground\Filters\ModelTrait::filterInteger()
 * @see \GammaMatrix\Playground\Filters\ModelTrait::filterPercent()
 */
class ValueTraitTest extends TraitTestCase
{
    /**
     * filterBoolean
     *
     * @see \GammaMatrix\Playground\Filters\ModelTrait::filterBoolean()
     */
    public function test_filterBoolean()
    {
        // Always return an array, no matter the input.

        // empty array
        $this->assertFalse($this->mock->filterBoolean([]));

        // NULL
        $this->assertFalse($this->mock->filterBoolean(null));

        // false
        $this->assertFalse($this->mock->filterBoolean([]));

        // true
        $this->assertTrue($this->mock->filterBoolean(true));

        // Positive numbers are true
        $this->assertTrue($this->mock->filterBoolean(10));
        $this->assertTrue($this->mock->filterBoolean(1));
        $this->assertFalse($this->mock->filterBoolean(0));
        $this->assertFalse($this->mock->filterBoolean(-10));

        // Empty string
        $this->assertFalse($this->mock->filterBoolean(''));

        $this->assertTrue($this->mock->filterBoolean('true'));

        $this->assertFalse($this->mock->filterBoolean('not-true'));

        $value = [
            'i' => 'am-a-test-array',
            'someNullValue' => null,
            'aString' => 'thanks!',
            'object' => (object) ['ok' => true,],
        ];

        $this->assertTrue($this->mock->filterBoolean($value));
    }

    /**
     * filterEmail
     *
     * @see \GammaMatrix\Playground\Filters\ModelTrait::filterEmail()
     */
    public function test_filterEmail()
    {
        $value = false;
        $this->assertSame('', $this->mock->filterEmail($value));

        $value = 'not valid email with spaces @ example.com';
        $this->assertSame('notvalidemailwithspaces@example.com', $this->mock->filterEmail($value));

        $value = 'test@';
        $this->assertSame($value, $this->mock->filterEmail($value));

        $value = 'test@example.com';
        $this->assertSame($value, $this->mock->filterEmail($value));
        $value = '<test@example.com>';
        $this->assertSame('test@example.com', $this->mock->filterEmail($value));

        $value = 'test+with.plus-addressing@example.com';
        $this->assertSame($value, $this->mock->filterEmail($value));
    }

    /**
     * filterHtml
     *
     * @see \GammaMatrix\Playground\Filters\ContentTrait::purify() HTMLPurifier
     * @see \GammaMatrix\Playground\Filters\ModelTrait::filterHtml()
     */
    public function test_filterHtml()
    {
        $value = '<b>Tags should be removed.</b>';
        $this->assertSame('Tags should be removed.', $this->mock->filterHtml($value));

        $value = '<a href="https://google.com">No links allowed either.</a>';
        $this->assertSame('No links allowed either.', $this->mock->filterHtml($value));
    }
}
