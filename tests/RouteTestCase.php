<?php
/**
 * GammaMatrix
 *
 */

namespace Tests;

/**
 * \Tests\RouteTestCase
 *
 */
class RouteTestCase extends TestCase
{
    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
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
