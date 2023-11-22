<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\Models\Traits\ScopeFilterIds;

use Tests\TestCase;
use GammaMatrix\Playground\Test\SqlTrait;
use Illuminate\Database\Eloquent\Builder;

/**
 * \Tests\Unit\Models\Traits\ScopeFilterIds\ModelTest
 *
 */
class ModelTest extends TestCase
{
    use SqlTrait {
        setUp as protected setUpSqlTrait;
    }

    /**
     * @var string
     */
    public const ABSTRACT_CLASS = \GammaMatrix\Playground\Models\Model::class;

    /**
     * @var object
     */
    public $mock;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->setUpSqlTrait();

        parent::setUp();

        if (!class_exists(static::ABSTRACT_CLASS)) {
            $this->markTestSkipped(sprintf(
                'Expecting the abstract model class to exist: %1$s',
                static::ABSTRACT_CLASS
            ));
        }

        $this->mock = $this->getMockForAbstractClass(static::ABSTRACT_CLASS);
    }

    public function test_scopeFilterIds_returns_query_without_ids_or_filters()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $query = $this->mock->filterIds([], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeFilterIds_returns_query_without_filters()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $query = $this->mock->filterIds([
            'id' => [],
            'owned_by_id' => [],
        ], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterIds_returns_query_with_invalid_column()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $ids = [
            'invalid ID' => [],
        ];

        $validated = [
            'filter' => [
                'invalid ID' => 'columns should be ignored',
            ],
        ];

        $query = $this->mock->filterIds($ids, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterIds_returns_query_with_null_comparison()
    {
        $sql = sprintf(
            'select * from `%1$s` where `id` is null and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $ids = [
            'id' => [],
            'owned_by_id' => [],
        ];

        $validated = [
            'filter' => [
                'id' => null,
            ],
        ];

        $query = $this->mock->filterIds($ids, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterIds_returns_query_with_comparison()
    {
        $sql = sprintf(
            'select * from `%1$s` where `id` = ? and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $ids = [
            'id' => [],
        ];

        $validated = [
            'filter' => [
                'id' => 'some-id',
            ],
        ];

        $query = $this->mock->filterIds($ids, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(1, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['id'], $bindings[0]);
    }

    public function test_scopeFilterIds_returns_query_with_filters_array()
    {
        $sql = sprintf(
            'select * from `%1$s` where `modified_by_id` in (?, ?, ?) and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $ids = [
            'id' => [
                'type' => 'uuid',
            ],
            'owned_by_id' => [],
            'modified_by_id' => [
                'type' => 'uuid',
            ],
            'project_id' => [],
            'invalid ID' => [],
        ];

        $validated = [
            'filter' => [
                'modified_by_id' => [
                    $this->faker()->uuid,
                    $this->faker()->uuid,
                    $this->faker()->uuid,
                    'ignore-not-a-valid-uuid',
                ],
                'invalid ID' => 'columns should be ignored',
            ],
        ];

        $query = $this->mock->filterIds($ids, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(3, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertArrayHasKey(1, $bindings);
        $this->assertArrayHasKey(2, $bindings);
        $this->assertSame($validated['filter']['modified_by_id'][0], $bindings[0]);
        $this->assertSame($validated['filter']['modified_by_id'][1], $bindings[1]);
        $this->assertSame($validated['filter']['modified_by_id'][2], $bindings[2]);
    }

    public function test_scopeFilterIds_returns_query_with_filters_with_integer()
    {
        $sql = sprintf(
            'select * from `%1$s` where `id` = ? and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $ids = [
            'id' => [
                'type' => 'integer',
            ],
            'owned_by_id' => [],
            'modified_by_id' => [
                'type' => 'uuid',
            ],
            'project_id' => [],
            'invalid ID' => [],
        ];

        $validated = [
            'filter' => [
                'id' => 123456,
                'invalid ID' => 'columns should be ignored',
            ],
        ];

        $query = $this->mock->filterIds($ids, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(1, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['id'], $bindings[0]);
    }

    public function test_scopeFilterIds_returns_query_with_array_of_ids_without_type()
    {
        $sql = sprintf(
            'select * from `%1$s` where `modified_by_id` in (?, ?, ?) and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $ids = [
            'id' => [],
            'owned_by_id' => [],
            'modified_by_id' => [],
            'project_id' => [],
            'invalid ID' => [],
        ];

        $id = $this->faker()->uuid;

        $validated = [
            'filter' => [
                'modified_by_id' => [
                    $id,
                    $this->faker()->uuid,
                    'this-id-is-not-ignored-not-a-valid-uuid',
                    $id,
                ],
            ],
        ];

        $query = $this->mock->filterIds($ids, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();

        $this->assertIsArray($bindings);
        $this->assertCount(3, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertArrayHasKey(1, $bindings);
        $this->assertArrayHasKey(2, $bindings);
        $this->assertSame($validated['filter']['modified_by_id'][0], $bindings[0]);
        $this->assertSame($validated['filter']['modified_by_id'][1], $bindings[1]);
        $this->assertSame($validated['filter']['modified_by_id'][2], $bindings[2]);
    }

    public function test_scopeFilterIds_returns_query_with_array_of_uuids_for_integer_type_ids_and_ignore()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $ids = [
            'id' => [],
            'owned_by_id' => [],
            'modified_by_id' => [
                'type' => 'integer'
            ],
            'project_id' => [],
            'invalid ID' => [],
        ];

        $validated = [
            'filter' => [
                'modified_by_id' => [
                    $this->faker()->uuid,
                    $this->faker()->uuid,
                    'this-id-is-not-ignored-not-a-valid-uuid',
                ],
            ],
        ];

        $query = $this->mock->filterIds($ids, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();

        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterIds_returns_query_with_array_of_integer_ids_ignore_duplicate_id()
    {
        $sql = sprintf(
            'select * from `%1$s` where `modified_by_id` in (?, ?) and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $ids = [
            'id' => [],
            'owned_by_id' => [],
            'modified_by_id' => [
                'type' => 'integer'
            ],
            'project_id' => [],
            'invalid ID' => [],
        ];

        $validated = [
            'filter' => [
                'modified_by_id' => [
                    123456,
                    // Duplicate IDs will be ignored.
                    123456,
                    999,
                ],
            ],
        ];

        $query = $this->mock->filterIds($ids, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();

        $this->assertIsArray($bindings);
        $this->assertCount(2, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertArrayHasKey(1, $bindings);
        $this->assertSame($validated['filter']['modified_by_id'][0], $bindings[0]);
        $this->assertSame($validated['filter']['modified_by_id'][2], $bindings[1]);
    }

    public function test_scopeFilterIds_returns_query_with_filters_with_null_and_string_and_array()
    {
        $sql = sprintf(
            'select * from `%1$s` where `id` = ? and `owned_by_id` is null and `modified_by_id` in (?, ?, ?) and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $ids = [
            'id' => [
                'type' => 'uuid',
            ],
            'owned_by_id' => [],
            'modified_by_id' => [
                'type' => 'uuid',
            ],
            'project_id' => [],
            'invalid ID' => [],
        ];

        $validated = [
            'filter' => [
                'id' => $this->faker()->uuid,
                'owned_by_id' => null,
                'project_id' => [0],
                'modified_by_id' => [
                    $this->faker()->uuid,
                    $this->faker()->uuid,
                    $this->faker()->uuid,
                    'ignore-not-a-valid-uuid',
                ],
                'invalid ID' => 'columns should be ignored',
            ],
        ];

        $query = $this->mock->filterIds($ids, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(4, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['id'], $bindings[0]);
        $this->assertArrayHasKey(1, $bindings);
        $this->assertSame($validated['filter']['modified_by_id'][0], $bindings[1]);
        $this->assertArrayHasKey(2, $bindings);
        $this->assertSame($validated['filter']['modified_by_id'][1], $bindings[2]);
        $this->assertArrayHasKey(3, $bindings);
        $this->assertSame($validated['filter']['modified_by_id'][2], $bindings[3]);
    }
}
