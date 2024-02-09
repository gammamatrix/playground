<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Filters\ModelTrait;

use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Filters\ModelTrait\SystemFieldsTraitTest
 *
 * @see \Playground\Filters\ModelTrait::filterSystemFields()
 * @see \Playground\Filters\ModelTrait::filterSystemFields()
 */
class SystemFieldsTraitTest extends TestCase
{
    /**
     * filterSystemFields: gids
     *
     * @see \Playground\Filters\ModelTrait::filterSystemFields()
     */
    public function test_filterSystemFields_for_groups(): void
    {
        $instance = new FilterModel;

        $this->assertSame([], $instance->filterSystemFields([]));

        $expected = ['gids' => 1];
        $this->assertSame($expected, $instance->filterSystemFields(['gids' => 1]));
    }

    /**
     * filterSystemFields: gids
     *
     * @see \Playground\Filters\ModelTrait::filterSystemFields()
     */
    public function test_filterSystemFields_for_permissions(): void
    {
        $instance = new FilterModel;

        $this->assertSame([], $instance->filterSystemFields([]));

        $expected = [
            'po' => 7,
            'pg' => 4,
            'pw' => 4,
        ];
        $this->assertSame($expected, $instance->filterSystemFields([
            'po' => 7,
            'pg' => 4,
            'pw' => 4,
        ]));

        // Only the permission bits may be set.

        $expected = [
            'po' => 4,
            'pg' => 4,
            'pw' => 4,
        ];
        $this->assertSame($expected, $instance->filterSystemFields([
            'po' => 100,
            'pg' => 4,
            'pw' => 4,
        ]));
    }

    /**
     * filterSystemFields: rank
     *
     * @see \Playground\Filters\ModelTrait::filterSystemFields()
     */
    public function test_filterSystemFields_for_rank(): void
    {
        $instance = new FilterModel;

        $expected = ['rank' => 0];
        $this->assertSame($expected, $instance->filterSystemFields(['rank' => 0]));

        $expected = ['rank' => 1];
        $this->assertSame($expected, $instance->filterSystemFields(['rank' => 1]));

        $expected = ['rank' => -1];
        $this->assertSame($expected, $instance->filterSystemFields(['rank' => -1]));
    }

    /**
     * filterSystemFields: size
     *
     * @see \Playground\Filters\ModelTrait::filterSystemFields()
     */
    public function test_filterSystemFields_for_size(): void
    {
        $instance = new FilterModel;

        $expected = ['size' => 0];
        $this->assertSame($expected, $instance->filterSystemFields(['size' => 0]));

        $expected = ['size' => 1];
        $this->assertSame($expected, $instance->filterSystemFields(['size' => 1]));

        $expected = ['size' => -1];
        $this->assertSame($expected, $instance->filterSystemFields(['size' => -1]));
    }
}
