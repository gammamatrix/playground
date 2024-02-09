<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\Traits\ScopeFilterTrash;

use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\MockObject\MockObject;
use Playground\Models\Model as TestModel;
use Playground\Test\SqlTrait;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Models\Traits\ScopeFilterTrash\ModelTest
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

    public function test_scopeFilterTrash_returns_query_with_empty_visibility(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $mock->getTable()
        );

        $query = $mock->filterTrash();

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeFilterTrash_returns_query_with_trash(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $visibility = 'with';

        $sql = sprintf(
            'select * from `%1$s`',
            $mock->getTable()
        );

        $query = $mock->filterTrash($visibility);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeFilterTrash_returns_query_with_only_trash(): void
    {
        /**
         * @var MockObject&TestModel
         */
        $mock = $this->getMockForAbstractClass(static::MODEL_CLASS);

        $visibility = 'only';

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is not null',
            $mock->getTable()
        );

        $query = $mock->filterTrash($visibility);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }
}
