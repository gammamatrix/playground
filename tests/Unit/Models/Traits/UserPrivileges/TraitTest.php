<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\Traits\UserPrivileges;

use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Models\Traits\UserPrivileges\TraitTest
 */
class TraitTest extends TestCase
{
    /**
     * @var string
     */
    public const TRAIT_CLASS = \Playground\Models\Traits\UserPrivileges::class;

    /**
     * @var object
     */
    public $mock;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (! trait_exists(static::TRAIT_CLASS)) {
            $this->markTestSkipped(sprintf(
                'Expecting the trait to exist: %1$s',
                static::TRAIT_CLASS
            ));
        }

        $this->mock = $this->getMockForTrait(static::TRAIT_CLASS);
    }

    public function test_hasPrivilege_is_false_with_null_privilege(): void
    {
        $privilege = null;
        $this->assertFalse($this->mock->hasPrivilege($privilege));
    }

    public function test_hasPrivilege_is_false_with_false_privilege(): void
    {
        $privilege = false;
        $this->assertFalse($this->mock->hasPrivilege($privilege));
    }

    public function test_hasPrivilege_is_true_with_privilege_that_does_exist(): void
    {
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValue(['user']));

        $privilege = 'user';
        $this->assertTrue($this->mock->hasPrivilege($privilege));
    }

    public function test_hasPrivilege_is_false_with_privilege_that_does_not_exist(): void
    {
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValue([]));

        $privilege = 'dog';
        $this->assertFalse($this->mock->hasPrivilege($privilege));
    }

    public function test_hasRole_is_false_with_null_role(): void
    {
        $role = null;
        $this->assertFalse($this->mock->hasRole($role));
    }

    public function test_hasRole_is_false_with_false_role(): void
    {
        $role = false;
        $this->assertFalse($this->mock->hasRole($role));
    }

    public function test_hasRole_is_true_with_role_that_does_exist(): void
    {
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValue(['user']));

        $role = 'user';
        $this->assertTrue($this->mock->hasRole($role));
    }

    public function test_hasRole_is_false_with_role_that_does_not_exist(): void
    {
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValue([]));

        $role = 'dog';
        $this->assertFalse($this->mock->hasRole($role));
    }

    public function test_hasRole_is_false_with_secondary_role_that_does_not_exist(): void
    {
        $map = [
            ['role', 'root'],
            ['roles', ['admin', 'wheel']],
        ];
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValueMap($map));

        $role = 'pickles';
        $this->assertFalse($this->mock->hasRole($role));
    }

    public function test_hasRole_is_true_with_secondary_role_that_does_exist(): void
    {
        $map = [
            ['role', 'root'],
            ['roles', ['admin', 'wheel']],
        ];
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValueMap($map));

        $role = 'wheel';
        $this->assertTrue($this->mock->hasRole($role));
    }

    public function test_hasRole_is_true_with_other_secondary_role_that_does_exist(): void
    {
        $map = [
            ['role', 'root'],
            ['roles', ['admin', 'wheel']],
        ];
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValueMap($map));

        $role = 'admin';
        $this->assertTrue($this->mock->hasRole($role));
    }

    public function test_hasRole_is_true_with_primary_role_that_does_exist(): void
    {
        $map = [
            ['role', 'root'],
            ['roles', ['admin', 'wheel']],
        ];
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValueMap($map));

        $role = 'root';
        $this->assertTrue($this->mock->hasRole($role));
    }

    public function test_isAdmin_is_false_without_roles(): void
    {
        $this->assertFalse($this->mock->isAdmin());
    }

    public function test_isAdmin_is_true_with_role_that_does_exist(): void
    {
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValue(['admin']));

        $this->assertTrue($this->mock->isAdmin());
    }

    public function test_isAdmin_is_false_with_user_role_that_does_not_exist(): void
    {
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValue([]));

        $this->assertFalse($this->mock->isAdmin());
    }

    public function test_isAdmin_is_false_with_secondary_role_that_does_not_exist(): void
    {
        $map = [
            ['role', 'user'],
            ['roles', ['user-admin']],
        ];
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValueMap($map));

        $this->assertFalse($this->mock->isAdmin());
    }

    public function test_isAdmin_is_false_with_secondary_roles_that_exist_and_not_admin(): void
    {
        $map = [
            ['role', 'manager'],
            ['roles', ['publisher']],
        ];
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValueMap($map));

        $this->assertFalse($this->mock->isAdmin());
    }

    public function test_isAdmin_is_true_with_other_secondary_role_that_does_exist(): void
    {
        $map = [
            ['role', 'support-admin'],
            ['roles', ['admin', 'staff']],
        ];
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValueMap($map));

        $this->assertTrue($this->mock->isAdmin());
    }

    public function test_isAdmin_is_true_with_primary_role_that_does_exist(): void
    {
        $map = [
            ['role', 'manager'],
            ['roles', ['admin', 'publisher']],
        ];
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValueMap($map));

        $this->assertTrue($this->mock->isAdmin());
    }

    public function test_isAdmin_is_false_with_secondary_root_role(): void
    {
        $map = [
            ['role', 'manager'],
            ['roles', ['root', 'publisher']],
        ];
        $this->mock->expects($this->any())
            ->method('getAttribute')
            ->will($this->returnValueMap($map));

        $this->assertFalse($this->mock->isAdmin());
    }
}
