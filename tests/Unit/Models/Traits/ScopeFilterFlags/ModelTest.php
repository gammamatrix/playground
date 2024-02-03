<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\Traits\ScopeFilterFlags;

use Illuminate\Database\Eloquent\Builder;
use Playground\Test\SqlTrait;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Models\Traits\ScopeFilterFlags\ModelTest
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

    public function test_scopeFilterFlags_returns_query_without_flags_or_filters()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $query = $this->mock->filterFlags([], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeFilterFlags_returns_query_without_filters()
    {
        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $query = $this->mock->filterFlags([
            'active' => [],
            'problem' => [],
        ], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterFlags_returns_query_with_filters()
    {
        $sql = sprintf(
            'select * from `%1$s` where `active` = ? and `problem` = ? and `%1$s`.`deleted_at` is null',
            $this->mock->getTable()
        );

        $query = $this->mock->filterFlags([
            'active' => [],
            'problem' => [],
        ], [
            'filter' => [
                'active' => 1,
                'problem' => false,
                '-- IS NULL' => 'does not matter',
            ],
        ]);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertArrayHasKey(0, $bindings);
        $this->assertTrue($bindings[0]);
        $this->assertArrayHasKey(1, $bindings);
        $this->assertFalse($bindings[1]);
        $this->assertCount(2, $bindings);
    }
}
