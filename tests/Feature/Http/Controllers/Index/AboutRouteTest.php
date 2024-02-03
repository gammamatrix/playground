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
 * \Tests\Feature\Playground\Http\Controllers\Index\AboutRouteTest
 *
 */
class AboutRouteTest extends TestCase
{
    public function test_route_about_as_guest_and_succeed()
    {
        $response = $this->get(route('about'));
        $response->assertStatus(200);
    }

    public function test_route_json_about_as_guest_and_succeed()
    {
        $response = $this->json('GET', route('about'));
        $response->assertStatus(200);
    }

    public function test_route_about_as_client_and_succeed()
    {
        $user = UserWithRole::find(User::factory()->create()->id);
        $user->role = 'client';
        $response = $this->actingAs($user)->get(route('about'));
        $response->assertStatus(200);
    }

    public function test_route_json_about_as_manager_and_succeed()
    {
        $user = UserWithRole::find(User::factory()->create()->id);
        $user->role = 'manager';
        $response = $this->actingAs($user)->getJson(route('about'));
        $response->assertStatus(200);
    }
}
