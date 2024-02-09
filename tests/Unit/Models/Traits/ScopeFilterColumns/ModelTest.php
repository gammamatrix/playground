<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\Traits\ScopeFilterColumns;

use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\MockObject\MockObject;
use Playground\Models\Model as TestModel;
use Playground\Test\SqlTrait;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Models\Traits\ScopeFilterColumns\ModelTest
 */
class ModelTest extends TestCase
{
    use SqlTrait {
        setUp as protected setUpSqlTrait;
    }

    /**
     * @var class-string
     */
    public const MODEL_CLASS = TestModel::class;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        $this->setUpSqlTrait();

        parent::setUp();

        if (! class_exists(static::MODEL_CLASS)) {
            $this->markTestSkipped(sprintf(
                'Expecting the abstract model class to exist: %1$s',
                static::MODEL_CLASS
            ));
        }
    }

    public function test_scopeFilterColumns_returns_query_without_columns_or_filters(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $query = $mock->filterColumns([], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeFilterColumns_returns_query_without_filters(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $query = $mock->filterColumns([
            'title' => [],
            'label' => [],
        ], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterColumns_returns_query_with_invalid_column(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $columns = [
            'invalid column' => [],
        ];

        $validated = [
            'filter' => [
                'invalid column' => 'columns should be ignored',
            ],
        ];

        $query = $mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterColumns_returns_query_with_filters_without_meta_for_strings(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `title` LIKE ? and `label` LIKE ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $columns = [
            'title' => [],
            'label' => [],
            'invalid column' => [],
        ];

        $validated = [
            'filter' => [
                'title' => '%wildcard%',
                'label' => 'Starts with%',
                'invalid' => 'columns should be ignored',
            ],
        ];

        $query = $mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['title'], $bindings[0]);
        $this->assertArrayHasKey(1, $bindings);
        $this->assertSame($validated['filter']['label'], $bindings[1]);
        $this->assertCount(2, $bindings);
    }

    public function test_scopeFilterColumns_returns_query_with_null_comparison_and_ignore(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $columns = [
            'title' => [],
            'label' => [],
        ];

        $validated = [
            'filter' => [
                'title' => null,
            ],
        ];

        $query = $mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterColumns_returns_query_with_comparison(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `title` LIKE ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $columns = [
            'title' => [],
        ];

        $validated = [
            'filter' => [
                'title' => 'Some Title',
            ],
        ];

        $query = $mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(1, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['title'], $bindings[0]);
    }

    public function test_scopeFilterColumns_with_boolean_filter_type_and_null_value(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `active` = ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $columns = [
            'active' => [
                'type' => 'boolean',
            ],
        ];

        $validated = [
            'filter' => [
                'active' => null,
            ],
        ];

        $query = $mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertFalse($bindings[0]);
        $this->assertCount(1, $bindings);
    }

    public function test_scopeFilterColumns_with_boolean_filter_type_and_true_value(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `active` = ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $columns = [
            'active' => [
                'type' => 'boolean',
            ],
        ];

        $validated = [
            'filter' => [
                'active' => true,
            ],
        ];

        $query = $mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertTrue($bindings[0]);
        $this->assertCount(1, $bindings);
    }

    public function test_scopeFilterColumns_with_boolean_filter_type_and_false_value(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `active` = ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $columns = [
            'active' => [
                'type' => 'boolean',
            ],
        ];

        $validated = [
            'filter' => [
                'active' => false,
            ],
        ];

        $query = $mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertFalse($bindings[0]);
        $this->assertCount(1, $bindings);
    }

    public function test_scopeFilterColumns_with_filter_operator_without_operator_and_default_to_like(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `title` LIKE ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $columns = [
            'title' => [],
        ];

        $validated = [
            'filter' => [
                'title' => [
                    'value' => 'Playground',
                ],
            ],
        ];

        $query = $mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['title']['value'], $bindings[0]);
        $this->assertCount(1, $bindings);
    }

    public function test_scopeFilterColumns_with_filter_operators(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $filter_operators = [
            '|' => [],
            '&' => [],
            '=' => [],
            '!=' => [],
            '<>' => [],
            '<=>' => [],
            '<' => [],
            '<=' => [],
            '>=' => [],
            'NULL' => [
                'remap' => 'is null',
                'parameter' => '',
                'no-bindings' => true,
            ],
            'NOTNULL' => [
                'remap' => 'is not null',
                'parameter' => '',
                'no-bindings' => true,
            ],
            'LIKE' => [],
            'NOTLIKE' => [
                'remap' => 'NOT LIKE',
            ],
            // 'BETWEEN' => [],
            // 'NOTBETWEEN' => [],
        ];

        $columns = [
            'title' => [
                // 'type' => 'string'
            ],
        ];

        $validated = [
            'filter' => [
                'title' => [
                    'operator' => '=',
                    'value' => 'Playground',
                ],
            ],
        ];

        foreach ($filter_operators as $operator => $meta) {

            $validated['filter']['title']['operator'] = $operator;

            if (! empty($meta['remap']) && is_string($meta['remap'])) {
                $operator = $meta['remap'];
            }

            if (array_key_exists('parameter', $meta) && is_string($meta['parameter'])) {
                $parameter = $meta['parameter'];
            } else {
                $parameter = ' ?';
            }

            $sql = sprintf(
                'select * from `%1$s` where `title` %2$s%3$s and `%1$s`.`deleted_at` is null',
                $mock->getTable(),
                $operator,
                $parameter
            );

            $query = $mock->filterColumns($columns, $validated);

            $this->assertInstanceOf(Builder::class, $query);

            $this->assertSame($this->replace_quotes($sql), $query->toSql());

            $bindings = $query->getBindings();
            $this->assertIsArray($bindings);

            if (! empty($meta['no-bindings'])) {
                $this->assertEmpty($bindings);
            } else {
                $this->assertCount(1, $bindings);
                $this->assertArrayHasKey(0, $bindings);
                $this->assertSame($validated['filter']['title']['value'], $bindings[0]);
            }
        }
    }

    public function test_scopeFilterColumns_with_between_filter_operator_without_single_parameter_and_ignore_between(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $columns = [
            'created_at' => [],
        ];

        $validated = [
            'filter' => [
                'created_at' => [
                    'operator' => 'BETWEEN',
                    'value' => 'today',
                ],
            ],
        ];

        $query = $mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterColumns_with_between_filter_operator(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `rank` between ? and ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $columns = [
            'rank' => [],
        ];

        $validated = [
            'filter' => [
                'rank' => [
                    'operator' => 'BETWEEN',
                    'value' => [100, 1000],
                ],
            ],
        ];

        $query = $mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['rank']['value'][0], $bindings[0]);
        $this->assertArrayHasKey(1, $bindings);
        $this->assertSame($validated['filter']['rank']['value'][1], $bindings[1]);
        $this->assertCount(2, $bindings);
    }

    public function test_scopeFilterColumns_with_not_between_filter_operator_without_single_parameter_and_ignore_between(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $columns = [
            'created_at' => [],
        ];

        $validated = [
            'filter' => [
                'created_at' => [
                    'operator' => 'NOTBETWEEN',
                    'value' => 'today',
                ],
            ],
        ];

        $query = $mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterColumns_with_not_between_filter_operator(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `rank` not between ? and ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $columns = [
            'rank' => [],
        ];

        $validated = [
            'filter' => [
                'rank' => [
                    'operator' => 'NOTBETWEEN',
                    'value' => [100, 1000],
                ],
            ],
        ];

        $query = $mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['rank']['value'][0], $bindings[0]);
        $this->assertArrayHasKey(1, $bindings);
        $this->assertSame($validated['filter']['rank']['value'][1], $bindings[1]);
        $this->assertCount(2, $bindings);
    }
}
