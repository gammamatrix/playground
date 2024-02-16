<?php
/**
 * Playground
 */
namespace Tests\Feature\Playground\Models\User;

use Playground\Models\User as TestModel;
use Tests\Feature\Playground\TestCase;

/**
 * \Tests\Feature\Playground\Models\User\ModelTest
 */
class ModelTest extends TestCase
{
    protected bool $load_migrations_playground = true;

    public function test_save_model_in_database(): void
    {
        /**
         * @var TestModel $user
         */
        $user = TestModel::factory()->make();

        $user->role = 'user';
        $this->assertTrue($user->hasRole('user'));

        $user->addAbility('site:*');
        $this->assertTrue($user->hasAbility('site:*'));

        $user->addPrivilege('jumping');
        $this->assertTrue($user->hasPrivilege('jumping'));

        $user->save();

        $attributes = $user->toArray();
        $this->assertIsArray($attributes);

        $this->assertArrayHasKey('abilities', $attributes);
        $this->assertSame(['site:*'], $attributes['abilities']);

        // privileges are hidden
        $this->assertArrayNotHasKey('privileges', $attributes);

        $this->assertArrayHasKey('role', $attributes);
        $this->assertSame('user', $attributes['role']);
    }
}
