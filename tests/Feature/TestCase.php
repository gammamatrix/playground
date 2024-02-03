<?php
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

    protected bool $load_UserWithRoleAndRolesAndPrivileges = false;

    protected bool $load_UserWithSanctum = false;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     'path' => dirname(dirname(__DIR__)) . '/database/migrations',
        // ]);
        if (! empty(env('TEST_DB_MIGRATIONS'))) {
            // $this->loadLaravelMigrations();
            if ($this->load_migrations_laravel) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-laravel');
            }
            if ($this->load_UserWithRoleAndRolesAndPrivileges) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-user-privileges');
            }
            if ($this->load_UserWithSanctum) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-sanctum');
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
        $app['config']->set('playground.auth.verify', 'user');

        $app['config']->set('playground.load.routes', true);
        $app['config']->set('playground.routes.about', true);
        $app['config']->set('playground.routes.bootstrap', true);
        $app['config']->set('playground.routes.dashboard', true);
        $app['config']->set('playground.routes.home', true);
        $app['config']->set('playground.routes.sitemap', true);
        $app['config']->set('playground.routes.theme', true);
        $app['config']->set('playground.routes.welcome', true);
    }
}
