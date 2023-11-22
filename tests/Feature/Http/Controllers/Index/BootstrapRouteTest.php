<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Feature\Http\Controllers;

use Tests\RouteTestCase;

/**
 * \Tests\Feature\Http\Controllers\BootstrapRouteTest
 *
 */
class BootstrapRouteTest extends RouteTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'playground.load.routes' => true,
            'playground.routes.bootstrap' => true,
        ]);
    }

    public function test_route_bootstrap_as_guest_and_succeed()
    {
        $response = $this->get('/bootstrap');
        $response->assertStatus(200);
    }

    public function test_route_json_bootstrap_as_guest_and_succeed()
    {
        $response = $this->json('GET', '/bootstrap');
        $response->assertStatus(200);
    }

    // public function test_route_bootstrap_as_vendor_and_succeed()
    // {
    //     $this->initAuthRoles();
    //     $response = $this->as('vendor')->get('/bootstrap');
    //     $response->assertStatus(200);
    // }

    // public function test_route_json_bootstrap_as_wheel_and_succeed()
    // {
    //     $this->initAuthRoles();
    //     $response = $this->as('wheel')->getJson('/bootstrap');
    //     $response->assertStatus(200);
    // }
}
