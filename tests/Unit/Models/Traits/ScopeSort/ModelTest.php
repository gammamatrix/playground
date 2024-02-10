<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\Traits\ScopeSort;

use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\MockObject\MockObject;
use Playground\Models\Model as TestModel;
use Playground\Test\SqlTrait;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Models\Traits\ScopeSort\ModelTest
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

    public function test_scopeSort_returns_query_with_empty_sort(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $this->assertInstanceOf(Builder::class, $mock->sort());

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $query = $mock->sort();

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_array_boolean_sort_asc(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sort = [
            'label' => true,
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` asc',
            $mock->getTable()
        );

        $query = $mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_array_boolean_sort_desc(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sort = [
            'title' => false,
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `title` desc',
            $mock->getTable()
        );

        $query = $mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_array_boolean_sort_pair(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sort = [
            'label' => false,
            'title' => true,
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` desc, `title` asc',
            $mock->getTable()
        );

        $query = $mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_array_boolean_sort_triplet(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sort = [
            'created_at' => true,
            'label' => true,
            'title' => false,
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `created_at` asc, `label` asc, `title` desc',
            $mock->getTable()
        );

        $query = $mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_csv_sort_asc(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sort = 'label';

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` asc',
            $mock->getTable()
        );
        $query = $mock->sort($sort);
        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_csv_sort_desc(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sort = '-created_at';

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `created_at` desc',
            $mock->getTable()
        );

        $query = $mock->sort($sort);

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
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sort = ['label'];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` asc',
            $mock->getTable()
        );

        $query = $mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_simple_array_desc(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sort = ['-label'];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` desc',
            $mock->getTable()
        );

        $query = $mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_hash_array_asc(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sort = [
            'label' => 'aSc',
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` asc',
            $mock->getTable()
        );

        $query = $mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeSort_returns_query_with_hash_array_desc(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sort = [
            'label' => 'dEsC',
        ];

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null order by `label` desc',
            $mock->getTable()
        );

        $query = $mock->sort($sort);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }
}
