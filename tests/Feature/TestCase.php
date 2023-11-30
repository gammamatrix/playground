<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Feature\GammaMatrix\Playground;

use GammaMatrix\Playground\Test\OrchestraTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use GammaMatrix\Playground\ServiceProvider;
use Illuminate\Contracts\Config\Repository;

/**
 * \Tests\Feature\GammaMatrix\Playground\TestCase
 *
 */
class TestCase extends OrchestraTestCase
{
    use DatabaseTransactions;

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

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
        if (!empty(env('TEST_DB_MIGRATIONS'))) {
            // $this->loadLaravelMigrations();
            $this->loadMigrationsFrom(dirname(dirname(__DIR__)) . '/database/migrations-laravel');
        }
    }

    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', 'GammaMatrix\\Playground\\Test\\Models\\User');
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
