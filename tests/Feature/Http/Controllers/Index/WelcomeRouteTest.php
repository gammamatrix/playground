<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Feature\GammaMatrix\Playground\Http\Controllers;

use Tests\Feature\GammaMatrix\Playground\TestCase;

/**
 * \Tests\Feature\GammaMatrix\Playground\Http\Controllers\WelcomeRouteTest
 *
 */
class WelcomeRouteTest extends TestCase
{
    public function test_route_welcome_as_guest_and_succeed()
    {
        $response = $this->get('/welcome');
        $response->assertStatus(200);
    }

    public function test_route_json_welcome_as_guest_and_succeed()
    {
        $response = $this->json('GET', '/welcome');
        $response->assertStatus(200);
    }

    // public function test_route_welcome_as_user_and_succeed()
    // {
    //     $this->initAuthRoles();
    //     $response = $this->as('user')->get('/welcome');
    //     $response->assertStatus(200);
    // }

    // public function test_route_json_welcome_as_manager_admin_and_succeed()
    // {
    //     $this->initAuthRoles();
    //     $response = $this->as('manager-admin')->getJson('/welcome');
    //     $response->assertStatus(200);
    // }
}
