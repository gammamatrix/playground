<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Policies\RoleTrait;

use Illuminate\Auth\Access\Response;
use Playground\Test\Models\User;
use Tests\Unit\Playground\TestCase;

// use PHPUnit\Framework\MockObject\MockObject;

/**
 * \Tests\Unit\Playground\Policies\RoleTrait\TraitTest
 */
class TraitTest extends TestCase
{
    public const TRAIT_CLASS = \Playground\Policies\RoleTrait::class;

    /**
     * var MockObject&\Playground\Policies\RoleTrait::class
     */
    public $mock;

    /**
     * Setup the test environment.
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

    public function test_getRolesForAdmin(): void
    {
        $expected = [
            'admin',
            'wheel',
            'root',
        ];

        $this->assertSame($expected, $this->mock->getRolesForAdmin());
    }

    public function test_getRolesForAction(): void
    {
        $expected = [
            'admin',
            'wheel',
            'root',
        ];

        $this->assertSame($expected, $this->mock->getRolesForAction());
    }

    public function test_getRolesToView(): void
    {
        $expected = [
            'admin',
            'wheel',
            'root',
        ];

        $this->assertSame($expected, $this->mock->getRolesToView());
    }

    public function test_hasRole(): void
    {
        $user = User::factory()->make();

        $ability = 'edit';
        $this->assertInstanceOf(Response::class, $this->mock->hasRole(
            $user,
            $ability
        ));
    }

    public function test_hasRole_advanced_role(): void
    {
        $user = User::factory()->make();

        $ability = 'some-advanded-role';
        $this->assertInstanceOf(Response::class, $this->mock->hasRole(
            $user,
            $ability
        ));
    }
}
