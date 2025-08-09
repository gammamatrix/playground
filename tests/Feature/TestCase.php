<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Tests\Feature\Playground;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Unit\Playground\PackageProviders;

/**
 * \Tests\Feature\Playground\TestCase
 */
class TestCase extends \Tests\Unit\Playground\TestCase
{
    use DatabaseTransactions;
    use PackageProviders;

    protected bool $hasMigrations = true;

    protected bool $load_migrations_laravel = false;

    protected bool $load_migrations_package = false;

    protected bool $load_migrations_playground = false;

    protected bool $setUpUserForPlayground = false;
}
