<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Models\Traits\ScopeFilterColumns;

use Tests\Unit\GammaMatrix\Playground\TestCase;
use GammaMatrix\Playground\Test\SqlTrait;
use Illuminate\Database\Eloquent\Builder;

/**
 * \Tests\Unit\GammaMatrix\Playground\Models\Traits\ScopeFilterColumns\ModelTest
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

    public function test_scopeFilterColumns_returns_query_without_columns_or_filters()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $query = $this->mock->filterColumns([], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeFilterColumns_returns_query_without_filters()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $query = $this->mock->filterColumns([
            'title' => [],
            'label' => [],
        ], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterColumns_returns_query_with_invalid_column()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $columns = [
            'invalid column' => [],
        ];

        $validated = [
            'filter' => [
                'invalid column' => 'columns should be ignored',
            ],
        ];

        $query = $this->mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterColumns_returns_query_with_filters_without_meta_for_strings()
    {
        $sql = sprintf(
            'select * from `%1$s` where `title` LIKE ? and `label` LIKE ? and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
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

        $query = $this->mock->filterColumns($columns, $validated);

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

    public function test_scopeFilterColumns_returns_query_with_null_comparison_and_ignore()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
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

        $query = $this->mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterColumns_returns_query_with_comparison()
    {
        $sql = sprintf(
            'select * from `%1$s` where `title` LIKE ? and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $columns = [
            'title' => [],
        ];

        $validated = [
            'filter' => [
                'title' => 'Some Title',
            ],
        ];

        $query = $this->mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(1, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['title'], $bindings[0]);
    }

    public function test_scopeFilterColumns_with_boolean_filter_type_and_null_value()
    {
        $sql = sprintf(
            'select * from `%1$s` where `active` = ? and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $columns = [
            'active' => [
                'type' => 'boolean'
            ],
        ];

        $validated = [
            'filter' => [
                'active' => null,
            ],
        ];

        $query = $this->mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertFalse($bindings[0]);
        $this->assertCount(1, $bindings);
    }

    public function test_scopeFilterColumns_with_boolean_filter_type_and_true_value()
    {
        $sql = sprintf(
            'select * from `%1$s` where `active` = ? and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $columns = [
            'active' => [
                'type' => 'boolean'
            ],
        ];

        $validated = [
            'filter' => [
                'active' => true,
            ],
        ];

        $query = $this->mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertTrue($bindings[0]);
        $this->assertCount(1, $bindings);
    }

    public function test_scopeFilterColumns_with_boolean_filter_type_and_false_value()
    {
        $sql = sprintf(
            'select * from `%1$s` where `active` = ? and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $columns = [
            'active' => [
                'type' => 'boolean'
            ],
        ];

        $validated = [
            'filter' => [
                'active' => false,
            ],
        ];

        $query = $this->mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertFalse($bindings[0]);
        $this->assertCount(1, $bindings);
    }

    public function test_scopeFilterColumns_with_filter_operator_without_operator_and_default_to_like()
    {
        $sql = sprintf(
            'select * from `%1$s` where `title` LIKE ? and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
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

        $query = $this->mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['title']['value'], $bindings[0]);
        $this->assertCount(1, $bindings);
    }

    public function test_scopeFilterColumns_with_filter_operators()
    {
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

            if (!empty($meta['remap']) && is_string($meta['remap'])) {
                $operator = $meta['remap'];
            }

            if (array_key_exists('parameter', $meta) && is_string($meta['parameter'])) {
                $parameter = $meta['parameter'];
            } else {
                $parameter = ' ?';
            }

            $sql = sprintf(
                'select * from `%1$s` where `title` %2$s%3$s and `%1$s`.`deleted_at` is null',
                $this->mock->getTable(),
                $operator,
                $parameter
            );

            $query = $this->mock->filterColumns($columns, $validated);

            $this->assertInstanceOf(Builder::class, $query);

            $this->assertSame($this->replace_quotes($sql), $query->toSql());

            $bindings = $query->getBindings();
            $this->assertIsArray($bindings);

            if (!empty($meta['no-bindings'])) {
                $this->assertEmpty($bindings);
            } else {
                $this->assertCount(1, $bindings);
                $this->assertArrayHasKey(0, $bindings);
                $this->assertSame($validated['filter']['title']['value'], $bindings[0]);
            }
        }
    }

    public function test_scopeFilterColumns_with_between_filter_operator_without_single_parameter_and_ignore_between()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
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

        $query = $this->mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterColumns_with_between_filter_operator()
    {
        $sql = sprintf(
            'select * from `%1$s` where `rank` between ? and ? and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
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

        $query = $this->mock->filterColumns($columns, $validated);

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

    public function test_scopeFilterColumns_with_not_between_filter_operator_without_single_parameter_and_ignore_between()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
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

        $query = $this->mock->filterColumns($columns, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterColumns_with_not_between_filter_operator()
    {
        $sql = sprintf(
            'select * from `%1$s` where `rank` not between ? and ? and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
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

        $query = $this->mock->filterColumns($columns, $validated);

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
