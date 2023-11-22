<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Feature\Http\Controllers;

use Tests\RouteTestCase;

/**
 * \Tests\Feature\Http\Controllers\HomeRouteTest
 *
 */
class HomeRouteTest extends RouteTestCase
{
    public function test_route_home_as_guest_and_succeed()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_route_json_home_as_guest_and_succeed()
    {
        $response = $this->json('GET', '/');
        $response->assertStatus(200);
    }

    // public function test_route_home_as_user_admin_and_succeed()
    // {
    //     $this->initAuthRoles();
    //     $response = $this->as('user-admin')->get('/');
    //     $response->assertStatus(200);
    // }

    // public function test_route_json_home_as_admin_and_succeed()
    // {
    //     $this->initAuthRoles();
    //     $response = $this->as('root')->getJson('/');
    //     $response->assertStatus(200);
    // }
}
