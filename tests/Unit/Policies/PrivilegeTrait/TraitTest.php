<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Policies\PrivilegeTrait;

use App\Models\User;
use GammaMatrix\Playground\Test\TestCase;
use Illuminate\Auth\Access\Response;

/**
 * \Tests\Unit\Playground\Policies\PrivilegeTrait\TraitTest
 *
 */
class TraitTest extends TestCase
{
    public const TRAIT_CLASS = \GammaMatrix\Playground\Policies\PrivilegeTrait::class;

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

    public function test_hasPrivilege()
    {
        $user = User::factory()->make();
        $privilege = '';

        $this->assertInstanceOf(Response::class, $this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    public function test_hasPrivilege_with_app()
    {
        $user = User::factory()->make();
        $privilege = 'app:*';

        $this->assertInstanceOf(Response::class, $this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }
}
