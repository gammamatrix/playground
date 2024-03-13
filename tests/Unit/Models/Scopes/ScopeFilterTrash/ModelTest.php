<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\Scopes\ScopeFilterTrash;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Playground\Test\SqlTrait;
use Tests\Unit\Playground\Models\TestModel;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Models\Scopes\ScopeFilterTrash\ModelTest
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

    public function test_scopeFilterTrash_returns_query_with_empty_visibility(): void
    {
        $instance = new TestModel;

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is null',
            $instance->getTable()
        );

        $query = $instance->filterTrash();

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeFilterTrash_returns_query_with_trash(): void
    {
        $instance = new TestModel;

        $visibility = 'with';

        $sql = sprintf(
            'select * from `%1$s`',
            $instance->getTable()
        );

        $query = $instance->filterTrash($visibility);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }

    public function test_scopeFilterTrash_returns_query_with_only_trash(): void
    {
        $instance = new TestModel;

        $visibility = 'only';

        $sql = sprintf(
            'select * from `%1$s` where `%1$s`.`deleted_at` is not null',
            $instance->getTable()
        );

        $query = $instance->filterTrash($visibility);

        $this->assertInstanceOf(Builder::class, $query);

        $this->assertSame($this->replace_quotes($sql), $query->toSql());
    }
}
