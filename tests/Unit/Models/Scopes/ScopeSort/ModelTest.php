<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\Scopes\ScopeSort;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Playground\Test\SqlTrait;
use Tests\Unit\Playground\Models\TestModel;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Models\Scopes\ScopeSort\ModelTest
 */
class ModelTest extends TestCase
{
    use SqlTrait {
        setUp as protected setUpSqlTrait;
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        $this->setUpSqlTrait();

        parent::setUp();

        Carbon::setTestNow(Carbon::now());
    }

    public function test_scopeSort_returns_query_with_empty_sort(): void
    {
        $instance = new TestModel;

        $this->assertInstanceOf(Builder::class, $instance->sort());

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $instance->getTable()
        );

        $query = $instance->sort();

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_array_boolean_sort_asc(): void
    {
        $instance = new TestModel;

        $sort = [
            'label' => true,
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` asc',
            $instance->getTable()
        );

        $query = $instance->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_array_boolean_sort_desc(): void
    {
        $instance = new TestModel;

        $sort = [
            'title' => false,
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `title` desc',
            $instance->getTable()
        );

        $query = $instance->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_array_boolean_sort_pair(): void
    {
        $instance = new TestModel;

        $sort = [
            'label' => false,
            'title' => true,
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` desc, `title` asc',
            $instance->getTable()
        );

        $query = $instance->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_array_boolean_sort_triplet(): void
    {
        $instance = new TestModel;

        $sort = [
            'created_at' => true,
            'label' => true,
            'title' => false,
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `created_at` asc, `label` asc, `title` desc',
            $instance->getTable()
        );

        $query = $instance->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_csv_sort_asc(): void
    {
        $instance = new TestModel;

        $sort = 'label';

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` asc',
            $instance->getTable()
        );
        $query = $instance->sort($sort);
        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_csv_sort_desc(): void
    {
        $instance = new TestModel;

        $sort = '-created_at';

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `created_at` desc',
            $instance->getTable()
        );

        $query = $instance->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$sql' => $sql,
        //     '$this->replace_quotes' => $this->replace_quotes,
        //     '$this->replace_quotes($sql)' => $this->replace_quotes($sql),
        // ]);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_simple_array_asc(): void
    {
        $instance = new TestModel;

        $sort = ['label'];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` asc',
            $instance->getTable()
        );

        $query = $instance->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_simple_array_desc(): void
    {
        $instance = new TestModel;

        $sort = ['-label'];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` desc',
            $instance->getTable()
        );

        $query = $instance->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_hash_array_asc(): void
    {
        $instance = new TestModel;

        $sort = [
            'label' => 'aSc',
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` asc',
            $instance->getTable()
        );

        $query = $instance->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_hash_array_desc(): void
    {
        $instance = new TestModel;

        $sort = [
            'label' => 'dEsC',
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` desc',
            $instance->getTable()
        );

        $query = $instance->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }
}
