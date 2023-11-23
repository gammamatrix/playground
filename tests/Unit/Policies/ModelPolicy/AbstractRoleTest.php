<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Policies\ModelPolicy;

use GammaMatrix\Playground\Test\Models\UserWithRoleAndRolesAndPrivileges as User;
use Tests\Unit\GammaMatrix\Playground\TestCase;
use Illuminate\Auth\Access\Response;

/**
 * \Tests\Unit\GammaMatrix\Playground\Policies\ModelPolicy\AbstractRoleTest
 *
 */
class AbstractRoleTest extends TestCase
{
    /**
     * @var string
     */
    public const ABSTRACT_CLASS = \GammaMatrix\Playground\Policies\ModelPolicy::class;

    /**
     * @var string
     */
    public const MODEL_CLASS = \GammaMatrix\Playground\Test\Models\User::class;

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

        if (!class_exists(static::MODEL_CLASS)) {
            $this->markTestSkipped(sprintf(
                'Expecting the model class to exist: %1$s',
                static::MODEL_CLASS
            ));
        }

        $this->mock = $this->getMockForAbstractClass(static::ABSTRACT_CLASS);
        config([
            'playground.auth.verify' => 'roles',
            'playground.auth.hasRole' => true,
            'playground.auth.userRoles' => true,
        ]);
    }

    // create()

    /**
     * Test create().
     *
     */
    public function test_create_without_role()
    {
        $user = User::factory()->make();

        $this->assertInstanceOf(Response::class, $this->mock->create($user));
    }

    /**
     * Test create().
     *
     */
    public function test_create_with_admin()
    {
        $user = User::factory()->make();

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $this->assertTrue($this->mock->create($user));
    }

    // delete()

    /**
     * Test delete().
     *
     */
    public function test_delete_without_role()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $this->assertInstanceOf(Response::class, $this->mock->delete($user, $model));
    }

    /**
     * Test delete().
     *
     */
    public function test_delete_with_admin()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $this->assertTrue($this->mock->delete($user, $model));
    }

    /**
     * Test delete().
     *
     */
    public function test_delete_locked_with_admin()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $model->locked = true;

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $response = $this->mock->delete($user, $model);

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertFalse($response->allowed());
        $this->assertTrue($response->denied());
        $this->assertSame(423, $response->status());

        // These could be customized:
        // $this->assertNull($response->code());
        // $this->assertNull($response->message());
    }

    // detail()

    /**
     * Test detail().
     *
     */
    public function test_detail_without_role()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $this->assertInstanceOf(Response::class, $this->mock->detail($user, $model));
    }

    /**
     * Test detail().
     *
     */
    public function test_detail_with_admin()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $this->assertTrue($this->mock->detail($user, $model));
    }

    // edit()

    /**
     * Test edit().
     *
     */
    public function test_edit_without_role()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $this->assertInstanceOf(Response::class, $this->mock->edit($user, $model));
    }

    /**
     * Test edit().
     *
     */
    public function test_edit_with_admin()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $this->assertTrue($this->mock->edit($user, $model));
    }

    // forceDelete()

    /**
     * Test forceDelete().
     *
     */
    public function test_forceDelete_without_role()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $this->assertInstanceOf(Response::class, $this->mock->forceDelete($user, $model));
    }

    /**
     * Test forceDelete().
     *
     */
    public function test_forceDelete_with_admin()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $this->assertTrue($this->mock->forceDelete($user, $model));
    }

    // lock()

    /**
     * Test lock().
     *
     */
    public function test_lock_without_role()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $this->assertInstanceOf(Response::class, $this->mock->lock($user, $model));
    }

    /**
     * Test lock().
     *
     */
    public function test_lock_with_admin()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $this->assertTrue($this->mock->lock($user, $model));
    }

    // manage()

    /**
     * Test manage().
     *
     */
    public function test_manage_without_role()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $this->assertInstanceOf(Response::class, $this->mock->manage($user, $model));
    }

    /**
     * Test manage().
     *
     */
    public function test_manage_with_admin()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $this->assertTrue($this->mock->manage($user, $model));
    }

    // restore()

    /**
     * Test restore().
     *
     */
    public function test_restore_without_role()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $this->assertInstanceOf(Response::class, $this->mock->restore($user, $model));
    }

    /**
     * Test restore().
     *
     */
    public function test_restore_with_admin()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $this->assertTrue($this->mock->restore($user, $model));
    }

    /**
     * Test store().
     *
     */
    public function test_store_without_role()
    {
        $user = User::factory()->make();

        $this->assertInstanceOf(Response::class, $this->mock->store($user));
    }

    /**
     * Test store().
     *
     */
    public function test_store_with_admin()
    {
        $user = User::factory()->make();

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $this->assertTrue($this->mock->store($user));
    }

    // update()

    /**
     * Test update().
     *
     */
    public function test_update_without_role()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $this->assertInstanceOf(Response::class, $this->mock->update($user, $model));
    }

    /**
     * Test update().
     *
     */
    public function test_update_with_admin()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $this->assertTrue($this->mock->update($user, $model));
    }

    /**
     * Test update().
     *
     */
    public function test_update_locked_with_admin()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $model->locked = true;

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $response = $this->mock->update($user, $model);

        $this->assertInstanceOf(
            \Illuminate\Auth\Access\Response::class,
            $response
        );

        $this->assertFalse($response->allowed());
        $this->assertTrue($response->denied());
        $this->assertSame(423, $response->status());

        // These could be customized:
        // $this->assertNull($response->code());
        // $this->assertNull($response->message());
    }

    // unlock()

    /**
     * Test unlock().
     *
     */
    public function test_unlock_without_role()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $this->assertInstanceOf(Response::class, $this->mock->unlock($user, $model));
    }

    /**
     * Test unlock().
     *
     */
    public function test_unlock_with_admin()
    {
        $user = User::factory()->make();

        $model_class = static::MODEL_CLASS;
        $model = new $model_class();

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $this->assertTrue($this->mock->unlock($user, $model));
    }
}
