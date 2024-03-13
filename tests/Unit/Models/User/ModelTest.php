<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Models\User;

use Playground\Models\User as TestModel;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\Models\User\ModelTest
 */
class ModelTest extends TestCase
{
    public function test_add_has_and_remove_Abilities(): void
    {
        $instance = new TestModel;

        $instance->setAttribute(
            'abilities',
            'the-value-should-be-a-string-and-will-be-removed'
        );

        $this->assertFalse($instance->hasAbility(false));
        $instance->removeAbility(false);

        $ability = 'admin:*';

        $this->assertFalse($instance->hasAbility($ability));

        // The ability will only be added once on repeated attempts.
        $instance->addAbility($ability);
        $instance->addAbility($ability);
        $this->assertTrue($instance->hasAbility($ability));

        $abilities = $instance->abilities;
        $this->assertIsArray($abilities);
        $this->assertCount(1, $abilities);
        $this->assertSame([$ability], $abilities);

        $instance->removeAbility($ability);
        $this->assertFalse($instance->hasAbility($ability));

        $abilities = $instance->abilities;
        $this->assertIsArray($abilities);
        $this->assertEmpty($abilities);
    }

    public function test_add_has_and_remove_Privileges(): void
    {
        $instance = new TestModel;

        $instance->setAttribute(
            'privileges',
            'the-value-should-be-a-string-and-will-be-removed'
        );

        $this->assertFalse($instance->hasPrivilege(false));
        $instance->removePrivilege(false);

        $privilege = 'running-with-scissors';

        $this->assertFalse($instance->hasPrivilege($privilege));

        // The privilege will only be added once on repeated attempts.
        $instance->addPrivilege($privilege);
        $instance->addPrivilege($privilege);
        $this->assertTrue($instance->hasPrivilege($privilege));

        $privileges = $instance->privileges;
        $this->assertIsArray($privileges);
        $this->assertCount(1, $privileges);
        $this->assertSame([$privilege], $privileges);

        $instance->removePrivilege($privilege);
        $this->assertFalse($instance->hasPrivilege($privilege));

        $privileges = $instance->privileges;
        $this->assertIsArray($privileges);
        $this->assertEmpty($privileges);
    }

    public function test_add_has_and_remove_Roles(): void
    {
        $primary_role = 'vendor';

        $instance = new TestModel([
            'role' => $primary_role,
        ]);

        // The primary role is not fillable
        $this->assertFalse($instance->hasRole($primary_role));

        $instance->setAttribute(
            'role',
            $primary_role
        );

        $instance->setAttribute(
            'roles',
            'the-value-should-be-a-string-and-will-be-removed'
        );

        $this->assertTrue($instance->hasRole($primary_role));

        $this->assertFalse($instance->hasRole(false));
        $instance->removeRole(false);

        // Remove role does not affect the primary role.
        $instance->removeRole($primary_role);
        $this->assertTrue($instance->hasRole($primary_role));

        $role = 'admin';

        $this->assertFalse($instance->hasRole($role));

        // The role will only be added once on repeated attempts.
        $instance->addRole($role);
        $instance->addRole($role);
        $this->assertTrue($instance->hasRole($role));

        $roles = $instance->roles;
        $this->assertIsArray($roles);
        $this->assertCount(1, $roles);
        $this->assertSame([$role], $roles);

        $instance->removeRole($role);
        $this->assertFalse($instance->hasRole($role));

        $roles = $instance->roles;
        $this->assertIsArray($roles);
        $this->assertEmpty($roles);

        // Root is forbidden as a secondary role.
        $role_root = 'root';
        $instance->addRole($role_root);
        $this->assertFalse($instance->hasRole($role_root));

        $roles = $instance->roles;
        $this->assertIsArray($roles);
        $this->assertEmpty($roles);
    }

    public function test_isAdmin_with_admins_and_users(): void
    {
        $instance_root = new TestModel();
        $this->assertFalse($instance_root->isAdmin());
        $instance_root->setAttribute('role', 'root');
        $this->assertTrue($instance_root->hasRole('root'));
        $this->assertTrue($instance_root->isAdmin());

        $instance_admin_secondary = new TestModel();
        $instance_admin_secondary->setAttribute('role', 'manager');
        $this->assertFalse($instance_admin_secondary->isAdmin());
        $this->assertTrue($instance_admin_secondary->hasRole('manager'));
        $instance_admin_secondary->addRole('admin');
        $this->assertTrue($instance_admin_secondary->isAdmin());
        // dump($instance_root->toArray());
    }
}
