<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Feature\GammaMatrix\Playground\Http\Controllers\Index;

use Tests\Feature\GammaMatrix\Playground\TestCase;

/**
 * \Tests\Feature\GammaMatrix\Playground\Http\Controllers\Index\ThemeRouteTest
 *
 */
class ThemeRouteTest extends TestCase
{
    public function test_route_theme_as_guest_and_succeed()
    {
        $response = $this->get('/theme');
        $response->assertRedirect('/');
    }

    public function test_route_theme_as_guest_with_preview_and_succeed()
    {
        $response = $this->json('GET', '/theme?preview');
        $response->assertStatus(200);
    }

    // public function test_route_theme_as_partner_and_succeed()
    // {
    //     $this->initAuthRoles();
    //     $response = $this->as('partner')->get('/theme?appTheme=bootstrap');
    //     $response->assertRedirect('/');
    // }

    // public function test_route_theme_as_sales_and_succeed_with_theme_and_redirect()
    // {
    //     $this->initAuthRoles();
    //     $response = $this->as('sales')->getJson('/theme?appTheme=bootstrap-dark&_return_url=%2Fsitemap');
    //     $response->assertRedirect('/sitemap');
    // }
}
