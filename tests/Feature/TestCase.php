<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground;

/**
 * \Tests\Feature\Playground\TestCase
 */
class TestCase extends \Tests\Unit\Playground\TestCase
{
    protected bool $load_migrations_laravel = false;

    protected bool $load_migrations_playground = false;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (! empty(env('TEST_DB_MIGRATIONS'))) {
            if ($this->load_migrations_laravel) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-laravel');
            }
            if ($this->load_migrations_playground) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-playground');
            }
        }
    }

    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', 'Playground\\Test\\Models\\User');
        $app['config']->set('playground-auth.verify', 'user');
    }
}
