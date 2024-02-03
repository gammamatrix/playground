<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\Policies\RoleTrait;

use Tests\Unit\Playground\TestCase;
use Playground\Test\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * \Tests\Unit\Playground\Policies\RoleTrait\TraitTest
 *
 */
class TraitTest extends TestCase
{
    public const TRAIT_CLASS = \Playground\Policies\RoleTrait::class;

    public $mock;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = $this->getMockForTrait(
            static::TRAIT_CLASS,
            [],
            '',
            true,
            true,
            true,
            $methods = []
        );
    }

    public function test_getRolesForAdmin()
    {
        $expected = [
            'admin',
            'wheel',
            'root',
        ];

        $this->assertSame($expected, $this->mock->getRolesForAdmin());
    }

    public function test_getRolesForAction()
    {
        $expected = [
            'admin',
            'wheel',
            'root',
        ];

        $this->assertSame($expected, $this->mock->getRolesForAction());
    }

    public function test_getRolesToView()
    {
        $expected = [
            'admin',
            'wheel',
            'root',
        ];

        $this->assertSame($expected, $this->mock->getRolesToView());
    }

    public function test_hasRole()
    {
        $user = User::factory()->make();

        $ability = 'edit';
        $this->assertInstanceOf(Response::class, $this->mock->hasRole(
            $user,
            $ability
        ));
    }

    public function test_hasRole_advanced_role()
    {
        $user = User::factory()->make();

        $ability = 'some-advanded-role';
        $this->assertInstanceOf(Response::class, $this->mock->hasRole(
            $user,
            $ability
        ));
    }
}
