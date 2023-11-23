<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Feature\GammaMatrix\Playground\Http\Controllers\Index;

use Tests\Feature\GammaMatrix\Playground\TestCase;

/**
 * \Tests\Feature\GammaMatrix\Playground\Http\Controllers\Index\AboutRouteTest
 *
 */
class AboutRouteTest extends TestCase
{
    public function test_route_about_as_guest_and_succeed()
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
    }

    public function test_route_json_about_as_guest_and_succeed()
    {
        $response = $this->json('GET', '/about');
        $response->assertStatus(200);
    }

    // public function test_route_about_as_client_and_succeed()
    // {
    //     $this->initAuthRoles();
    //     $response = $this->as('client')->get('/about');
    //     $response->assertStatus(200);
    // }

    // public function test_route_json_about_as_manager_and_succeed()
    // {
    //     $this->initAuthRoles();
    //     $response = $this->as('manager')->getJson('/about');
    //     $response->assertStatus(200);
    // }
}
