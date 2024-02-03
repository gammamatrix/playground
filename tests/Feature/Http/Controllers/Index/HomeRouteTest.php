<?php
/**
 * Playground
 *
 */

namespace Tests\Feature\Playground\Http\Controllers\Index;

use Playground\Test\Models\User;
use Playground\Test\Models\UserWithRole;
use Tests\Feature\Playground\TestCase;

/**
 * \Tests\Feature\Playground\Http\Controllers\Index\HomeRouteTest
 *
 */
class HomeRouteTest extends TestCase
{
    public function test_route_home_as_guest_and_succeed()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    public function test_route_json_home_as_guest_and_succeed()
    {
        $response = $this->json('GET', route('home'));
        $response->assertStatus(200);
    }

    public function test_route_home_as_user_admin_and_succeed()
    {
        $user = UserWithRole::find(User::factory()->create()->id);
        $user->role = 'user-admin';
        $response = $this->actingAs($user)->get(route('home'));
        $response->assertStatus(200);
    }

    public function test_route_json_home_as_admin_and_succeed()
    {
        $user = UserWithRole::find(User::factory()->create()->id);
        $user->role = 'root';
        $response = $this->actingAs($user)->getJson(route('home'));
        $response->assertStatus(200);
    }
}
