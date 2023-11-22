<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\Models\Traits\ScopeFilterDates;

use Tests\TestCase;
use GammaMatrix\Playground\Test\SqlTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \Tests\Unit\Models\Traits\ScopeFilterDates\ModelTest
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
        if (!class_exists(static::ABSTRACT_CLASS)) {
            $this->markTestSkipped(sprintf(
                'Expecting the abstract model class to exist: %1$s',
                static::ABSTRACT_CLASS
            ));
        }

        $this->setUpSqlTrait();

        parent::setUp();

        Carbon::setTestNow(Carbon::now());

        $this->mock = $this->getMockForAbstractClass(static::ABSTRACT_CLASS);
    }

    public function test_scopeFilterDates_returns_query_without_dates_or_filters()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $query = $this->mock->filterDates([], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeFilterDates_returns_query_without_filters()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $query = $this->mock->filterDates([
            'created_at' => [],
            'updated_at' => [],
        ], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterDates_returns_query_with_invalid_column()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $dates = [
            'invalid date' => [],
        ];

        $validated = [
            'filter' => [
                'invalid date' => 'dates should be ignored',
            ],
        ];

        $query = $this->mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterDates_returns_query_with_filters_without_meta_for_strings()
    {
        $sql = sprintf(
            'select * from `%1$s` where `updated_at` >= ? and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
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

        $query = $this->mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(1, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame($validated['filter']['updated_at'].' 00:00:00', $bindings[0]);
    }

    public function test_scopeFilterDates_returns_query_with_null_comparison_and_ignore()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $dates = [
            'updated_at' => [],
            'created_at' => [],
            'closed_at' => [
                'nullable' => false
            ],
        ];

        $validated = [
            'filter' => [
                'created_at' => null,
                'closed_at' => null,
            ],
        ];

        $query = $this->mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterDates_returns_query_with_null_comparison_and_allow()
    {
        $sql = sprintf(
            // 'select * from `%1$s` where `%1$s`.`closed_at` is null and `%1$s`.`deleted_at` is null',
            'select * from `%1$s` where `closed_at` is null and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $dates = [
            'updated_at' => [],
            'created_at' => [],
            'closed_at' => [
                'nullable' => true
            ],
        ];

        $validated = [
            'filter' => [
                'closed_at' => null,
            ],
        ];

        $query = $this->mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterDates_returns_query_with_comparison()
    {
        $sql = sprintf(
            // 'select * from `%1$s` where `%1$s`.`updated_at` LIKE ? and `%1$s`.`deleted_at` is null',
            'select * from `%1$s` where `updated_at` >= ? and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $dates = [
            'updated_at' => [],
        ];

        $validated = [
            'filter' => [
                'updated_at' => 'now',
            ],
        ];

        $query = $this->mock->filterDates($dates, $validated);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertCount(1, $bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertSame(Carbon::now()->format('Y-m-d H:i:s'), $bindings[0]);
    }
}
