<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Feature\GammaMatrix\Playground\Http\Controllers;

use GammaMatrix\Playground\Test\TestCase;
use GammaMatrix\Playground\Test\AuthTrait;

/**
 * \Tests\Feature\GammaMatrix\Playground\Http\Controllers\BootstrapRouteTest
 *
 */
class BootstrapRouteTest extends TestCase
{
    use AuthTrait;

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
