<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Policies\RoleTrait;

use App\Models\User;
use GammaMatrix\Playground\Test\TestCase;
use Illuminate\Auth\Access\Response;

/**
 * \Tests\Unit\Playground\Policies\RoleTrait\TraitTest
 *
 */
class TraitTest extends TestCase
{
    public const TRAIT_CLASS = \GammaMatrix\Playground\Policies\RoleTrait::class;

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
}
