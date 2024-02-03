<?php
/**
 * Playground
 */
namespace Tests\Feature\Playground\Http\Controllers\Index;

use Playground\Test\Models\User;
use Playground\Test\Models\UserWithRole;
use Tests\Feature\Playground\TestCase;

/**
 * \Tests\Feature\Playground\Http\Controllers\Index\DashboardRouteTest
 */
class DashboardRouteTest extends TestCase
{
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
        $response = $this->get(route('dashboard'));
        $response->assertRedirect('/');
    }

    public function test_route_dashboard_as_guest_and_redirect_when_disabled_for_guest()
    {
        config([
            'playground.dashboard.enable' => true,
            'playground.dashboard.guest' => false,
        ]);
        $response = $this->get(route('dashboard'));
        $response->assertRedirect('/');
    }

    public function test_route_json_dashboard_as_guest_and_succeed()
    {
        config([
            'playground.dashboard.enable' => true,
            'playground.dashboard.guest' => true,
        ]);
        $response = $this->json('GET', route('dashboard'));
        $response->assertStatus(200);
    }

    public function test_route_dashboard_as_user_and_succeed()
    {
        config([
            'playground.dashboard.enable' => true,
            'playground.dashboard.guest' => false,
        ]);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertStatus(200);
    }

    public function test_route_dashboard_as_user_and_fail_when_disabled_for_all()
    {
        config([
            'playground.dashboard.enable' => false,
        ]);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertRedirect('/');
    }

    public function test_route_dashboard_as_user_and_fail_when_disabled_for_all_and_no_redirect()
    {
        config([
            'playground.dashboard.enable' => false,
        ]);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('dashboard', ['noredirect' => 1]));
        $response->assertStatus(400);
    }

    public function test_route_json_dashboard_as_admin_and_succeed()
    {
        config([
            'playground.dashboard.enable' => true,
        ]);
        $user = UserWithRole::find(User::factory()->create()->id);
        $user->role = 'admin';
        $response = $this->actingAs($user)->getJson(route('dashboard'));
        $response->assertStatus(200);
    }
}
