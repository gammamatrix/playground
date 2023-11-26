<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground;

use GammaMatrix\Playground\Test\OrchestraTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use GammaMatrix\Playground\ServiceProvider;
use Illuminate\Contracts\Config\Repository;

/**
 * \Tests\Unit\GammaMatrix\Playground\TestCase
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
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', 'GammaMatrix\\Playground\\Test\\Models\\User');
        $app['config']->set('playground.auth.verify', 'user');
    }
}
