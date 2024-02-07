<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Filters\ModelTrait;

/**
 * \Tests\Unit\Playground\Filters\ModelTrait\ArrayTraitTest
 *
 * @see \Playground\Filters\ModelTrait::filterArray()
 * @see \Playground\Filters\ModelTrait::filterArrayToJson()
 */
class ArrayTraitTest extends TraitTestCase
{
    /**
     * filterArray
     *
     * @see \Playground\Filters\ModelTrait::filterArray()
     */
    public function test_filterArray(): void
    {
        // Always return an array, no matter the input.

        // empty array
        $this->assertSame([], $this->mock->filterArray([]));

        // NULL
        $this->assertSame([], $this->mock->filterArray(null));

        // false
        $this->assertSame([], $this->mock->filterArray(false));

        // true
        $this->assertSame([], $this->mock->filterArray(true));

        $value = 'just-a-string-value';

        // A string is converted to any array.
        $this->assertSame([$value], $this->mock->filterArray($value));

        // A test array should not be altered.
        $value = [
            'i' => 'am-a-test-array',
            'someNullValue' => null,
            'aString' => 'thanks!',
            'object' => (object) ['ok' => true],
        ];

        // Returns the same array.
        $this->assertSame($value, $this->mock->filterArray($value));
    }

    /**
     * filterArrayToJson
     *
     * @see \Playground\Filters\ModelTrait::filterArrayToJson()
     */
    public function test_filterArray_to_json(): void
    {
        // Unexpected values return a json encoded empty array..

        // empty array
        $this->assertSame(json_encode([]), $this->mock->filterArrayToJson([]));

        // NULL
        $this->assertSame(json_encode([]), $this->mock->filterArrayToJson(null));

        // false
        $this->assertSame(json_encode([]), $this->mock->filterArrayToJson(false));

        // true
        $this->assertSame(json_encode([]), $this->mock->filterArrayToJson(true));

        $value = 'just-a-string-value';

        // A string will remain a string, unchanged.
        $this->assertSame($value, $this->mock->filterArrayToJson($value));

        // A test array should not be altered.
        $value = [
            'i' => 'am-a-test-array',
            'someNullValue' => null,
            'aString' => 'thanks!',
            'object' => (object) ['ok' => true],
        ];

        // Returns the same array.
        $this->assertSame(json_encode($value), $this->mock->filterArrayToJson($value));
    }
}
