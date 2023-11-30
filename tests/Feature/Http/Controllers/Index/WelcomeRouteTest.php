<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Feature\GammaMatrix\Playground\Http\Controllers\Index;

use GammaMatrix\Playground\Test\Models\User;
use GammaMatrix\Playground\Test\Models\UserWithRole;
use Tests\Feature\GammaMatrix\Playground\TestCase;

/**
 * \Tests\Feature\GammaMatrix\Playground\Http\Controllers\Index\WelcomeRouteTest
 *
 */
class WelcomeRouteTest extends TestCase
{
    public function test_route_welcome_as_guest_and_succeed()
    {
        $response = $this->get(route('welcome'));
        $response->assertStatus(200);
    }

    public function test_route_json_welcome_as_guest_and_succeed()
    {
        $response = $this->json('GET', route('welcome'));
        $response->assertStatus(200);
    }

    public function test_route_welcome_as_user_and_succeed()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route('welcome'));
        $response->assertStatus(200);
    }

    public function test_route_json_welcome_as_manager_admin_and_succeed()
    {
        $user = UserWithRole::find(User::factory()->create()->id);
        $user->role = 'manager-admin';
        $response = $this->actingAs($user)->getJson(route('welcome'));
        $response->assertStatus(200);
    }
}
