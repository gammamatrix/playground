<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Policies\PolicyTrait;

use App\Models\User;
use GammaMatrix\Playground\Test\TestCase;

/**
 * \Tests\Unit\Playground\Policies\PolicyTrait\TraitTest
 *
 */
class TraitTest extends TestCase
{
    /**
     * @var string
     */
    const TRAIT_CLASS = \GammaMatrix\Playground\Policies\PolicyTrait::class;

    /**
     * @var object
     */
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

    /**
     * Test getRolesForAdmin().
     *
     */
    public function test_getRolesForAdmin()
    {
        $expected = [
            'admin',
            'wheel',
            'root',
        ];

        $this->assertSame($expected, $this->mock->getRolesForAdmin());
    }

    /**
     * Test getRolesForAction().
     *
     */
    public function test_getRolesForAction()
    {
        $expected = [
            'admin',
            'wheel',
            'root',
        ];

        $this->assertSame($expected, $this->mock->getRolesForAction());
    }

    /**
     * Test getRolesToView().
     *
     */
    public function test_getRolesToView()
    {
        $expected = [
            'admin',
            'wheel',
            'root',
        ];

        $this->assertSame($expected, $this->mock->getRolesToView());
    }

    /**
     * Test hasPrivilege().
     *
     */
    public function test_hasPrivilege()
    {
        $user = User::factory()->make();
        $privileges = [];

        $this->assertFalse($this->mock->hasPrivilege(
            $user,
            $privileges
        ));
    }

    /**
     * Test hasPrivilege().
     *
     */
    public function test_hasPrivilege_with_admin()
    {
        $user = User::factory()->make();
        $privileges = [
            'admin',
        ];

        $user->privileges = $privileges;

        $this->assertTrue($this->mock->hasPrivilege(
            $user,
            $privileges
        ));

        $this->assertFalse($this->mock->hasPrivilege(
            $user,
            ['root']
        ));

        $this->assertFalse($this->mock->hasPrivilege(
            $user,
            ['root', 'wheel']
        ));

        $this->assertTrue($this->mock->hasPrivilege(
            $user,
            ['admin', 'root', 'wheel']
        ));
    }

    /**
     * Test hasRole().
     *
     */
    public function test_hasRole()
    {
        $user = User::factory()->make();
        $roles = [];

        $this->assertFalse($this->mock->hasRole(
            $user,
            $roles
        ));
    }

    /**
     * Test hasRole().
     *
     */
    public function test_hasRole_with_admin()
    {
        $user = User::factory()->make();
        $roles = [
            'admin',
        ];

        $user->roles = $roles;

        $this->assertTrue($this->mock->hasRole(
            $user,
            $roles
        ));

        $this->assertFalse($this->mock->hasRole(
            $user,
            ['root']
        ));

        $this->assertFalse($this->mock->hasRole(
            $user,
            ['root', 'wheel']
        ));

        $this->assertTrue($this->mock->hasRole(
            $user,
            ['admin', 'root', 'wheel']
        ));
    }
}

