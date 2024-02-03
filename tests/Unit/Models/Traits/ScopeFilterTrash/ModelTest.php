<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\Traits\ScopeFilterTrash;

use Illuminate\Database\Eloquent\Builder;
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
     * @var string
     */
    public const ABSTRACT_CLASS = \Playground\Models\Model::class;

    /**
     * @var object
     */
    public $mock;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        $this->setUpSqlTrait();

        parent::setUp();

        if (! class_exists(static::ABSTRACT_CLASS)) {
            $this->markTestSkipped(sprintf(
                'Expecting the abstract model class to exist: %1$s',
                static::ABSTRACT_CLASS
            ));
        }

        $this->mock = $this->getMockForAbstractClass(static::ABSTRACT_CLASS);
    }

    public function test_scopeFilterTrash_returns_query_with_empty_visibility()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $query = $this->mock->filterTrash();

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeFilterTrash_returns_query_with_trash()
    {
        $visibility = 'with';

        $sql = sprintf(
            'select * from `%1$s`',
            $this->mock->getTable()
        );

        $query = $this->mock->filterTrash($visibility);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeFilterTrash_returns_query_with_only_trash()
    {
        $visibility = 'only';

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is not null',
            $this->mock->getTable()
        );

        $query = $this->mock->filterTrash($visibility);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }
}
