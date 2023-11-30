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
 * \Tests\Feature\GammaMatrix\Playground\Http\Controllers\Index\SitemapRouteTest
 *
 */
class SitemapRouteTest extends TestCase
{
    public function test_route_sitemap_as_guest_and_fail_when_disabled_for_guest_and_no_redirect()
    {
        config([
            'playground.sitemap.enable' => true,
            'playground.sitemap.guest' => false,
        ]);
        $response = $this->get('/sitemap?noredirect');
        $response->assertStatus(400);
    }

    public function test_route_sitemap_as_guest_and_redirect_when_disabled_for_all()
    {
        config([
            'playground.sitemap.enable' => false,
        ]);
        $response = $this->get(route('sitemap'));
        $response->assertRedirect('/');
    }

    public function test_route_sitemap_as_guest_and_redirect_when_disabled_for_guest()
    {
        config([
            'playground.sitemap.enable' => true,
            'playground.sitemap.guest' => false,
        ]);
        $response = $this->get(route('sitemap'));
        $response->assertRedirect('/');
    }

    public function test_route_json_sitemap_as_guest_and_succeed()
    {
        config([
            'playground.sitemap.enable' => true,
            'playground.sitemap.guest' => true,
        ]);
        $response = $this->json('GET', route('sitemap'));
        $response->assertStatus(200);
    }

    public function test_route_sitemap_as_user_and_succeed()
    {
        config([
            'playground.sitemap.enable' => true,
            'playground.sitemap.guest' => false,
        ]);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('sitemap'));
        $response->assertStatus(200);
    }

    public function test_route_sitemap_as_support_and_fail_when_disabled_for_all()
    {
        config([
            'playground.sitemap.enable' => false,
        ]);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('sitemap'));
        $response->assertRedirect('/');
    }

    public function test_route_sitemap_as_user_and_fail_when_disabled_for_all_and_no_redirect()
    {
        config([
            'playground.sitemap.enable' => false,
        ]);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('sitemap', ['noredirect' => 1]));
        $response->assertStatus(400);
    }

    public function test_route_json_sitemap_as_admin_and_succeed()
    {
        config([
            'playground.sitemap.enable' => true,
        ]);
        $user = UserWithRole::find(User::factory()->create()->id);
        // The role is not saved since the column may not exist.
        $user->role = 'admin';
        $response = $this->actingAs($user)->getJson(route('sitemap'));
        $response->assertStatus(200);
    }

    public function test_route_sitemap_as_user_and_succeed_with_package_sitemaps()
    {
        config([
            'playground.load.views' => true,
            'playground.sitemap.enable' => true,
            'playground.sitemap.guest' => false,
            'playground.sitemap.packages' => 'playground-auth',
        ]);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('sitemap'));
        $response->assertStatus(200);
    }
}
