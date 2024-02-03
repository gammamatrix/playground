<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Policies\PrivilegeTrait;

use Illuminate\Auth\Access\Response;
use Playground\Test\Models\UserWithRoleAndRolesAndPrivileges;
use Playground\Test\Models\UserWithSanctum;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Policies\PrivilegeTrait\TraitTest
 */
class TraitTest extends TestCase
{
    public const TRAIT_CLASS = \Playground\Policies\PrivilegeTrait::class;

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

    public function test_privilege_without_parameter()
    {
        $expected = '*';

        $this->assertSame($expected, $this->mock->privilege());
    }

    public function test_privilege_with_package_and_without_parameter()
    {
        $package = 'testing';
        $expected = 'testing:*';

        $this->mock->expects($this->any())
            ->method('getPackage')
            ->will($this->returnValue($package));

        $this->assertSame($expected, $this->mock->privilege());
    }

    public function test_privilege_with_package_and_entity_and_without_parameter()
    {
        $package = 'testing';
        $entity = 'model';
        $expected = 'testing:model:*';

        $this->mock->expects($this->any())
            ->method('getPackage')
            ->will($this->returnValue($package));

        $this->mock->expects($this->any())
            ->method('getEntity')
            ->will($this->returnValue($entity));

        $this->assertSame($expected, $this->mock->privilege());
    }

    public function test_hasPrivilege()
    {
        config(['playground.auth.sanctum' => true]);
        $user = UserWithSanctum::factory()->make();
        $privilege = '';

        $this->assertInstanceOf(Response::class, $this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    public function test_hasPrivilege_with_user_hasPrivilege()
    {
        config(['playground.auth.hasPrivilege' => true]);

        $user = UserWithRoleAndRolesAndPrivileges::factory()->make([
            'privileges' => ['quack'],
        ]);
        $privilege = 'quack';

        $this->assertTrue($this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    public function test_hasPrivilege_with_user_privileges()
    {
        config(['playground.auth.userPrivileges' => true]);

        $user = UserWithRoleAndRolesAndPrivileges::factory()->make([
            'privileges' => ['quack'],
        ]);
        $privilege = 'quack';

        $this->assertTrue($this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    public function test_hasPrivilege_without_privileges_enabled()
    {
        config([
            'playground.auth.hasPrivilege' => false,
            'playground.auth.userPrivileges' => false,
        ]);
        $user = UserWithRoleAndRolesAndPrivileges::factory()->make([
            'privileges' => ['quack'],
        ]);
        $privilege = 'quack';

        $this->assertInstanceOf(Response::class, $this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }
}
