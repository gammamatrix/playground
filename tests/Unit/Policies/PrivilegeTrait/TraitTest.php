<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\Policies\PrivilegeTrait;

use Tests\TestCase;
use GammaMatrix\Playground\Test\Models\UserWithSanctum;
use Illuminate\Auth\Access\Response;

/**
 * \Tests\Unit\Policies\PrivilegeTrait\TraitTest
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
        $user = UserWithSanctum::factory()->make();
        $privilege = '';

        $this->assertInstanceOf(Response::class, $this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    // Requires a database
    // public function test_hasPrivilege_with_app()
    // {
    //     $user = UserWithSanctum::factory()->make();
    //     $privilege = 'app:*';

    //     $this->assertInstanceOf(Response::class, $this->mock->hasPrivilege(
    //         $user,
    //         $privilege
    //     ));
    // }
}
