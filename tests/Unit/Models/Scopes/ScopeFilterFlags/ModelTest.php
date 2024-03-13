<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\Scopes\ScopeFilterFlags;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Playground\Test\SqlTrait;
use Tests\Unit\Playground\Models\TestModel;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Models\Scopes\ScopeFilterFlags\ModelTest
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

    public function test_scopeFilterFlags_returns_query_without_flags_or_filters(): void
    {
        $instance = new TestModel;

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $instance->getTable()
        );

        $query = $instance->filterFlags([], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeFilterFlags_returns_query_without_filters(): void
    {
        $instance = new TestModel;

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $instance->getTable()
        );

        $query = $instance->filterFlags([
            'active' => [],
            'problem' => [],
        ], []);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());

        $bindings = $query->getBindings();
        $this->assertIsArray($bindings);
        $this->assertEmpty($bindings);
    }

    public function test_scopeFilterFlags_returns_query_with_filters(): void
    {
        $instance = new TestModel;

        $sql = sprintf(
            'select * from `%1$s` where `active` = ? and `problem` = ? and `%1$s`.`deleted_at` is null',
            $instance->getTable()
        );

        $query = $instance->filterFlags([
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
