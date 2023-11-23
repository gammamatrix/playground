<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Models\Traits\ScopeSort;

use Tests\Unit\GammaMatrix\Playground\TestCase;
use GammaMatrix\Playground\Test\SqlTrait;
use Illuminate\Database\Eloquent\Builder;

/**
 * \Tests\Unit\GammaMatrix\Playground\Models\Traits\ScopeSort\ModelTest
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

    public function test_scopeSort_returns_query_with_empty_sort()
    {
        $this->assertInstanceOf(Builder::class, $this->mock->sort());

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $query = $this->mock->sort();

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_array_boolean_sort_asc()
    {
        $sort = [
            'label' => true,
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` asc',
            $this->mock->getTable()
        );

        $query = $this->mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_array_boolean_sort_desc()
    {
        $sort = [
            'title' => false,
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `title` desc',
            $this->mock->getTable()
        );

        $query = $this->mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_array_boolean_sort_pair()
    {
        $sort = [
            'label' => false,
            'title' => true,
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` desc, `title` asc',
            $this->mock->getTable()
        );

        $query = $this->mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_array_boolean_sort_triplet()
    {
        $sort = [
            'created_at' => true,
            'label' => true,
            'title' => false,
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `created_at` asc, `label` asc, `title` desc',
            $this->mock->getTable()
        );

        $query = $this->mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_csv_sort_asc()
    {
        $sort = 'label';

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` asc',
            $this->mock->getTable()
        );
        $query = $this->mock->sort($sort);
        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_csv_sort_desc()
    {
        $sort = '-created_at';

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `created_at` desc',
            $this->mock->getTable()
        );

        $query = $this->mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$sql' => $sql,
        //     '$this->replace_quotes' => $this->replace_quotes,
        //     '$this->replace_quotes($sql)' => $this->replace_quotes($sql),
        // ]);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_simple_array_asc()
    {
        $sort = ['label'];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` asc',
            $this->mock->getTable()
        );

        $query = $this->mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_simple_array_desc()
    {
        $sort = ['-label'];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` desc',
            $this->mock->getTable()
        );

        $query = $this->mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);


        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_hash_array_asc()
    {
        $sort = [
            'label' => 'aSc',
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` asc',
            $this->mock->getTable()
        );

        $query = $this->mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_hash_array_desc()
    {
        $sort = [
            'label' => 'dEsC',
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` desc',
            $this->mock->getTable()
        );

        $query = $this->mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }
}
