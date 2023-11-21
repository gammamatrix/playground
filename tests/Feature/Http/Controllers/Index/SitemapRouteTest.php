<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Feature\GammaMatrix\Playground\Http\Controllers;

use GammaMatrix\Playground\Test\TestCase;
use GammaMatrix\Playground\Test\AuthTrait;

/**
 * \Tests\Feature\GammaMatrix\Playground\Http\Controllers\SitemapRouteTest
 *
 */
class SitemapRouteTest extends TestCase
{
    use AuthTrait;

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
        $response = $this->get('/sitemap');
        $response->assertRedirect('/');
    }

    public function test_route_sitemap_as_guest_and_redirect_when_disabled_for_guest()
    {
        config([
            'playground.sitemap.enable' => true,
            'playground.sitemap.guest' => false,
        ]);
        $response = $this->get('/sitemap');
        $response->assertRedirect('/');
    }

    public function test_route_json_sitemap_as_guest_and_succeed()
    {
        config([
            'playground.sitemap.enable' => true,
            'playground.sitemap.guest' => true,
        ]);
        $response = $this->json('GET', '/sitemap');
        $response->assertStatus(200);
    }

    // public function test_route_sitemap_as_user_and_succeed()
    // {
    //     config([
    //         'playground.sitemap.enable' => true,
    //         'playground.sitemap.guest' => false,
    //     ]);
    //     $this->initAuthRoles();
    //     $response = $this->as('user')->get('/sitemap');
    //     $response->assertStatus(200);
    // }

    // public function test_route_sitemap_as_support_and_fail_when_disabled_for_all()
    // {
    //     config([
    //         'playground.sitemap.enable' => false,
    //     ]);
    //     $this->initAuthRoles();
    //     $response = $this->as('support')->get('/sitemap');
    //     $response->assertRedirect('/');
    // }

    // public function test_route_sitemap_as_user_and_fail_when_disabled_for_all_and_no_redirect()
    // {
    //     config([
    //         'playground.sitemap.enable' => false,
    //     ]);
    //     $this->initAuthRoles();
    //     $response = $this->get('/sitemap?noredirect');
    //     $response->assertStatus(400);
    // }

    // public function test_route_json_sitemap_as_support_admin_and_succeed()
    // {
    //     config([
    //         'playground.sitemap.enable' => true,
    //     ]);
    //     $this->initAuthRoles();
    //     $response = $this->as('support-admin')->getJson('/sitemap');
    //     $response->assertStatus(200);
    // }
}
