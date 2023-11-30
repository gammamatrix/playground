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
 * \Tests\Feature\GammaMatrix\Playground\Http\Controllers\Index\BootstrapRouteTest
 *
 */
class BootstrapRouteTest extends TestCase
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
        $response = $this->get(route('bootstrap'));
        $response->assertStatus(200);
    }

    public function test_route_json_bootstrap_as_guest_and_succeed()
    {
        $response = $this->json('GET', route('bootstrap'));
        $response->assertStatus(200);
    }

    public function test_route_bootstrap_as_vendor_and_succeed()
    {
        $user = UserWithRole::find(User::factory()->create()->id);
        $user->role = 'vendor';
        $response = $this->actingAs($user)->get(route('bootstrap'));
        $response->assertStatus(200);
    }

    public function test_route_json_bootstrap_as_wheel_and_succeed()
    {
        $user = UserWithRole::find(User::factory()->create()->id);
        $user->role = 'wheel';
        $response = $this->actingAs($user)->getJson(route('bootstrap'));
        $response->assertStatus(200);
    }
}
