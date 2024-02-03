<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Filters\ModelTrait;

/**
 * \Tests\Unit\Playground\Filters\ModelTrait\SystemFieldsTraitTest
 *
 * @see \Playground\Filters\ModelTrait::filterSystemFields()
 * @see \Playground\Filters\ModelTrait::filterSystemFields()
 */
class SystemFieldsTraitTest extends TraitTestCase
{
    /**
     * filterSystemFields: gids
     *
     * @see \Playground\Filters\ModelTrait::filterSystemFields()
     */
    public function test_filterSystemFields_for_groups()
    {
        $this->assertSame([], $this->mock->filterSystemFields([]));

        $expected = ['gids' => 1];
        $this->assertSame($expected, $this->mock->filterSystemFields(['gids' => 1]));
    }

    /**
     * filterSystemFields: gids
     *
     * @see \Playground\Filters\ModelTrait::filterSystemFields()
     */
    public function test_filterSystemFields_for_permissions()
    {
        $this->assertSame([], $this->mock->filterSystemFields([]));

        $expected = [
            'po' => 7,
            'pg' => 4,
            'pw' => 4,
        ];
        $this->assertSame($expected, $this->mock->filterSystemFields([
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
        $this->assertSame($expected, $this->mock->filterSystemFields([
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
    public function test_filterSystemFields_for_rank()
    {
        $expected = ['rank' => 0];
        $this->assertSame($expected, $this->mock->filterSystemFields(['rank' => 0]));

        $expected = ['rank' => 1];
        $this->assertSame($expected, $this->mock->filterSystemFields(['rank' => 1]));

        $expected = ['rank' => -1];
        $this->assertSame($expected, $this->mock->filterSystemFields(['rank' => -1]));
    }

    /**
     * filterSystemFields: size
     *
     * @see \Playground\Filters\ModelTrait::filterSystemFields()
     */
    public function test_filterSystemFields_for_size()
    {
        $expected = ['size' => 0];
        $this->assertSame($expected, $this->mock->filterSystemFields(['size' => 0]));

        $expected = ['size' => 1];
        $this->assertSame($expected, $this->mock->filterSystemFields(['size' => 1]));

        $expected = ['size' => -1];
        $this->assertSame($expected, $this->mock->filterSystemFields(['size' => -1]));
    }
}
