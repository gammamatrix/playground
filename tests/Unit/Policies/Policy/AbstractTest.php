<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Policies\Policy;

use App\Models\User;
use GammaMatrix\Playground\Test\TestCase;

/**
 * \Tests\Unit\Playground\Policies\Policy\AbstractTest
 *
 */
class AbstractTest extends TestCase
{
    /**
     * @var string
     */
    public const ABSTRACT_CLASS = \GammaMatrix\Playground\Policies\Policy::class;

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

        $this->mock = $this->getMockForAbstractClass(static::ABSTRACT_CLASS);
    }

    /**
     * Test before().
     *
     */
    public function test_before_with_root()
    {
        $user = User::factory()->make();
        $ability = 'edit';

        $role = 'root';

        $user->role = $role;

        $this->assertTrue($this->mock->before(
            $user,
            $ability
        ));
    }

    /**
     * Test before().
     *
     */
    public function test_before_with_root_as_secondary_fails()
    {
        $user = User::factory()->make();
        $ability = 'edit';

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $this->assertNull($this->mock->before(
            $user,
            $ability
        ));
    }

    /**
     * Test index().
     *
     */
    public function test_index_without_role()
    {
        $user = User::factory()->make();

        $this->assertFalse($this->mock->index($user));
    }

    /**
     * Test index().
     *
     */
    public function test_index_with_admin()
    {
        $user = User::factory()->make();

        $role = 'admin';
        $roles = [
            'root',
        ];

        $user->role = $role;

        $this->assertTrue($this->mock->index($user));
    }

    /**
     * Test view().
     *
     */
    public function test_view_without_role()
    {
        $user = User::factory()->make();

        $this->assertFalse($this->mock->view($user));
    }

    /**
     * Test view().
     *
     */
    public function test_view_with_admin()
    {
        $user = User::factory()->make();

        $role = 'admin';
        $roles = [
            'wheel',
            'user',
        ];

        $user->role = $role;

        $this->assertTrue($this->mock->view($user));
    }
}
