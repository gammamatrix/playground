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
 * \Tests\Feature\GammaMatrix\Playground\Http\Controllers\Index\ThemeRouteTest
 *
 */
class ThemeRouteTest extends TestCase
{
    public function test_route_theme_as_guest_and_succeed()
    {
        $response = $this->get(route('theme'));
        $response->assertRedirect('/');
    }

    public function test_route_theme_as_guest_with_preview_and_succeed()
    {
        $response = $this->json('GET', route('theme', ['preview' => true]));
        $response->assertStatus(200);
    }

    public function test_route_theme_as_partner_and_succeed()
    {
        $user = UserWithRole::find(User::factory()->create()->id);
        $user->role = 'partner';
        $response = $this->actingAs($user)->get(route('theme', [
            'appTheme' => 'dark',
        ]));
        $response->assertRedirect('/');
    }

    public function test_route_theme_as_sales_and_succeed_with_theme_and_redirect()
    {
        $user = UserWithRole::find(User::factory()->create()->id);
        $user->role = 'sales';
        $response = $this->actingAs($user)->get(route('theme', [
            'appTheme' => 'dark',
            '_return_url' => route('sitemap'),
        ]));
        $response->assertRedirect(route('sitemap'));
    }
}
