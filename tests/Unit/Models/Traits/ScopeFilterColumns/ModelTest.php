<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Models\Traits\ScopeFilterColumns;

use GammaMatrix\Playground\Test\TestCase;
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
}
