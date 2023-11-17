<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Feature\GammaMatrix\Playground\Http\Controllers;

use GammaMatrix\Playground\Test\TestCase;
use GammaMatrix\Playground\Test\AuthTrait;

/**
 * \Tests\Feature\GammaMatrix\Playground\Http\Controllers\DashboardRouteTest
 *
 */
class DashboardRouteTest extends TestCase
{
    use AuthTrait;

    public function test_route_dashboard_as_guest_and_fail_when_disabled_for_guest_and_no_redirect()
    {
        config([
            'playground.dashboard.enable' => true,
            'playground.dashboard.guest' => false,
        ]);
        $response = $this->get('/dashboard?noredirect');
        $response->assertStatus(400);
    }

    public function test_route_dashboard_as_guest_and_redirect_when_disabled_for_all()
    {
        config([
            'playground.dashboard.enable' => false,
        ]);
        $response = $this->get('/dashboard');
        $response->assertRedirect('/');
    }

    public function test_route_dashboard_as_guest_and_redirect_when_disabled_for_guest()
    {
        config([
            'playground.dashboard.enable' => true,
            'playground.dashboard.guest' => false,
        ]);
        $response = $this->get('/dashboard');
        $response->assertRedirect('/');
    }

    public function test_route_json_dashboard_as_guest_and_succeed()
    {
        config([
            'playground.dashboard.enable' => true,
            'playground.dashboard.guest' => true,
        ]);
        $response = $this->json('GET', '/dashboard');
        $response->assertStatus(200);
    }

    public function test_route_dashboard_as_user_and_succeed()
    {
        config([
            'playground.dashboard.enable' => true,
            'playground.dashboard.guest' => false,
        ]);
        $this->initAuthRoles();
        $response = $this->as('user')->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_route_dashboard_as_user_and_fail_when_disabled_for_all()
    {
        config([
            'playground.dashboard.enable' => false,
        ]);
        $this->initAuthRoles();
        $response = $this->as('user')->get('/dashboard');
        $response->assertRedirect('/');
    }

    public function test_route_dashboard_as_user_and_fail_when_disabled_for_all_and_no_redirect()
    {
        config([
            'playground.dashboard.enable' => false,
        ]);
        $this->initAuthRoles();
        $response = $this->get('/dashboard?noredirect');
        $response->assertStatus(400);
    }

    public function test_route_json_dashboard_as_admin_and_succeed()
    {
        config([
            'playground.dashboard.enable' => true,
        ]);
        $this->initAuthRoles();
        $response = $this->as('admin')->getJson('/dashboard');
        $response->assertStatus(200);
    }
}
