<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\Traits\ScopeFilterDates;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\MockObject\MockObject;
use Playground\Models\Model as TestModel;
use Playground\Test\SqlTrait;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Models\Traits\ScopeFilterDates\ModelTest
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
        if (! class_exists(static::MODEL_CLASS)) {
            $this->markTestSkipped(sprintf(
                'Expecting the abstract model class to exist: %1$s',
                static::MODEL_CLASS
            ));
        }

        $this->setUpSqlTrait();

        parent::setUp();

        Carbon::setTestNow(Carbon::now());
    }

    public function test_scopeFilterDates_returns_query_without_dates_or_filters(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $query = $mock->filterDates([], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeFilterDates_returns_query_without_filters(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $query = $mock->filterDates([
            'created_at' => [],
            'updated_at' => [],
        ], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterDates_returns_query_with_invalid_column(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'invalid date' => [],
        ];

        $validated = [
            'filter' => [
                'invalid date' => 'dates should be ignored',
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterDates_returns_query_with_filters_without_meta_for_strings(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `updated_at` >= ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'updated_at' => [],
            'created_at' => [],
            'invalid date' => [],
        ];

        $validated = [
            'filter' => [
                'updated_at' => Carbon::parse('yesterday')->format('Y-m-d'),
                'invalid date' => 'dates should be ignored',
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(1, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['updated_at'].' 00:00:00', $bindings[0]);
    }

    public function test_scopeFilterDates_returns_query_with_null_comparison_and_ignore(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'updated_at' => [],
            'created_at' => [],
            'closed_at' => [
                'nullable' => false,
            ],
        ];

        $validated = [
            'filter' => [
                'created_at' => null,
                'closed_at' => null,
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterDates_returns_query_with_null_comparison_and_allow(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            // 'select * from `%1$s` where `%1$s`.`closed_at` is null and `%1$s`.`deleted_at` is null',
            'select * from `%1$s` where `closed_at` is null and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'updated_at' => [],
            'created_at' => [],
            'closed_at' => [
                'nullable' => true,
            ],
        ];

        $validated = [
            'filter' => [
                'closed_at' => null,
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterDates_returns_query_with_comparison(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            // 'select * from `%1$s` where `%1$s`.`updated_at` LIKE ? and `%1$s`.`deleted_at` is null',
            'select * from `%1$s` where `updated_at` >= ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'updated_at' => [],
        ];

        $validated = [
            'filter' => [
                'updated_at' => 'now',
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(1, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame(Carbon::now()->format('Y-m-d H:i:s'), $bindings[0]);
    }

    public function test_scopeFilterDates_returns_query_with_wildcard(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `updated_at` LIKE ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'updated_at' => [],
        ];

        $validated = [
            'filter' => [
                'updated_at' => '2020-10%',
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(1, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['updated_at'], $bindings[0]);
    }

    public function test_scopeFilterDates_returns_query_with_operator_wildcard(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `updated_at` LIKE ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'updated_at' => [],
        ];

        $validated = [
            'filter' => [
                'updated_at' => [
                    'value' => '2020-10%',
                ],
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(1, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['updated_at']['value'], $bindings[0]);
    }

    public function test_scopeFilterDates_returns_query_with_object_value_and_ignore(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'updated_at' => [],
        ];

        $validated = [
            'filter' => [
                'updated_at' => (object) [
                    'label' => 'some',
                    'value' => null,
                ],
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterDates_returns_query_with_unnullable_value_and_ignore(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'updated_at' => [],
        ];

        $validated = [
            'filter' => [
                'updated_at' => [
                    'value' => null,
                ],
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterDates_returns_query_with_invalid_operator_and_use_like(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `updated_at` >= ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'updated_at' => [],
        ];

        $validated = [
            'filter' => [
                'updated_at' => [
                    'operator' => 'duck',
                    'value' => 'now',
                ],
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(1, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame(
            Carbon::parse($validated['filter']['updated_at']['value'])->format('Y-m-d H:i:s'),
            $bindings[0]
        );
    }

    public function test_scopeFilterDates_returns_query_with_invalid_parsable_value_and_ignore(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'updated_at' => [],
        ];

        $validated = [
            'filter' => [
                'updated_at' => [
                    'operator' => 'duck',
                    'value' => 'quack',
                ],
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterDates_returns_query_with_short_date_and_gte_operator(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `updated_at` >= ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'updated_at' => [],
        ];

        $validated = [
            'filter' => [
                'updated_at' => [
                    'operator' => '>=',
                    'value' => '2020-10-01',
                ],
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(1, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['updated_at']['value'], $bindings[0]);
    }

    public function test_scopeFilterDates_returns_query_with_phrase_date_and_automatically_parse(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `updated_at` = ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'updated_at' => [],
        ];

        $validated = [
            'filter' => [
                'updated_at' => [
                    'operator' => '=',
                    'value' => 'midnight last week',
                ],
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(1, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame(
            Carbon::parse($validated['filter']['updated_at']['value'])->format('Y-m-d H:i:s'),
            $bindings[0]
        );
    }

    public function test_scopeFilterDates_with_between_filter_operator_with_parse(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `created_at` between ? and ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'created_at' => [],
        ];

        $validated = [
            'filter' => [
                'created_at' => [
                    'operator' => 'BETWEEN',
                    'parse' => true,
                    'value' => ['yesterday', 'last week'],
                ],
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);

        $this->assertSame(
            Carbon::parse($validated['filter']['created_at']['value'][0])->format('Y-m-d H:i:s'),
            $bindings[0]
        );
        $this->assertSame(
            Carbon::parse($validated['filter']['created_at']['value'][1])->format('Y-m-d H:i:s'),
            $bindings[1]
        );

        $this->assertCount(2, $bindings);
    }

    public function test_scopeFilterDates_with_not_between_filter_operator_with_parse(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `created_at` not between ? and ? and `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $dates = [
            'created_at' => [],
        ];

        $validated = [
            'filter' => [
                'created_at' => [
                    'operator' => 'NOTBETWEEN',
                    'parse' => true,
                    'value' => ['yesterday', 'last week'],
                ],
            ],
        ];

        $query = $mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);

        $this->assertSame(
            Carbon::parse($validated['filter']['created_at']['value'][0])->format('Y-m-d H:i:s'),
            $bindings[0]
        );
        $this->assertSame(
            Carbon::parse($validated['filter']['created_at']['value'][1])->format('Y-m-d H:i:s'),
            $bindings[1]
        );

        $this->assertCount(2, $bindings);
    }

    public function test_scopeFilterDates_with_filter_operators(): void
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

        $dates = [
            'created_at' => [
                // 'type' => 'string'
            ],
        ];

        $validated = [
            'filter' => [
                'created_at' => [
                    'operator' => '=',
                    'value' => '2000-01-01 00:00:00',
                ],
            ],
        ];

        foreach ($filter_operators as $operator => $meta) {

            $validated['filter']['created_at']['operator'] = $operator;

            if (! empty($meta['remap']) && is_string($meta['remap'])) {
                $operator = $meta['remap'];
            }

            if (array_key_exists('parameter', $meta) && is_string($meta['parameter'])) {
                $parameter = $meta['parameter'];
            } else {
                $parameter = ' ?';
            }

            $sql = sprintf(
                'select * from `%1$s` where `created_at` %2$s%3$s and `%1$s`.`deleted_at` is null',
                $mock->getTable(),
                $operator,
                $parameter
            );

            $query = $mock->filterDates($dates, $validated);

            $this->assertInstanceOf(Builder::class, $query);

            $this->assertSame($this->replace_quotes($sql), $query->toSql());

            $bindings = $query->getBindings();
            $this->assertIsArray($bindings);

            if (! empty($meta['no-bindings'])) {
                $this->assertEmpty($bindings);
            } else {
                $this->assertCount(1, $bindings);
                $this->assertArrayHasKey(0, $bindings);
                $this->assertSame($validated['filter']['created_at']['value'], $bindings[0]);
            }
        }
    }
}