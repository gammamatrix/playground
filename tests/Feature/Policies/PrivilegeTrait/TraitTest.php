<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Feature\GammaMatrix\Playground\Policies\PrivilegeTrait;

use Tests\Feature\GammaMatrix\Playground\TestCase;
use GammaMatrix\Playground\Test\Models\UserWithSanctum;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * \Tests\Feature\GammaMatrix\Playground\Policies\PrivilegeTrait\TraitTest
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

    public function test_hasPrivilege_and_fail_with_empty_privilege()
    {
        $user = UserWithSanctum::factory()->make();
        $privilege = '';

        $this->assertInstanceOf(Response::class, $this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    public function test_hasPrivilege_with_app_without_token_and_fail()
    {
        $user = UserWithSanctum::factory()->make();
        $privilege = 'app:*';

        $this->assertInstanceOf(Response::class, $this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    public function test_hasPrivilege_with_app_with_wildcard_token_privileges_and_succeed()
    {
        $this->mock->expects($this->any())
            ->method('hasToken')
            ->will($this->returnValue(true))
        ;

        $user = UserWithSanctum::factory()->create();
        $privilege = 'app:*';

        $name = 'app';
        $privileges = [
            'app:*',
            'view:*',
        ];
        $expiresAt = new Carbon('+5 minutes');

        $token = $user->createToken($name, $privileges, $expiresAt);
        // $token->plainTextToken;

        $access_token = $user->tokens()
            ->where('name', config('playground.auth.token.name'))
            // Get the latest created token.
            ->orderBy('created_at', 'desc')
            ->firstOrFail()
        ;

        $this->assertInstanceOf(PersonalAccessToken::class, $access_token);

        $this->mock->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($access_token))
        ;

        $this->assertTrue($this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    public function test_hasPrivilege_with_app_with_wildcard_secondary_token_privileges_and_succeed()
    {
        $this->mock->expects($this->any())
            ->method('hasToken')
            ->will($this->returnValue(true))
        ;

        $user = UserWithSanctum::factory()->create();
        $privilege = 'playground-matrix-resource:backlog:view';
        $privilege = 'playground-matrix-resource:backlog:*';

        $name = 'app';
        $privileges = [
            'playground-matrix-resource:backlog:*',
            'playground-matrix:view',
            'playground-matrix-resource:view',
        ];
        $expiresAt = new Carbon('+5 minutes');

        $token = $user->createToken($name, $privileges, $expiresAt);
        // $token->plainTextToken;

        $access_token = $user->tokens()
            ->where('name', config('playground.auth.token.name'))
            // Get the latest created token.
            ->orderBy('created_at', 'desc')
            ->firstOrFail()
        ;

        $this->assertInstanceOf(PersonalAccessToken::class, $access_token);

        $this->mock->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($access_token))
        ;

        $this->assertTrue($this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    public function test_hasPrivilege_with_app_with_token_privileges_and_succeed()
    {
        $this->mock->expects($this->any())
            ->method('hasToken')
            ->will($this->returnValue(true))
        ;

        $user = UserWithSanctum::factory()->create();
        $privilege = 'app';

        $name = 'app';
        $privileges = [
            'app',
            'view',
        ];
        $expiresAt = new Carbon('+5 minutes');

        $token = $user->createToken($name, $privileges, $expiresAt);
        // $token->plainTextToken;

        $access_token = $user->tokens()
            ->where('name', config('playground.auth.token.name'))
            // Get the latest created token.
            ->orderBy('created_at', 'desc')
            ->firstOrFail()
        ;

        $this->assertInstanceOf(PersonalAccessToken::class, $access_token);

        $this->mock->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($access_token))
        ;

        $this->assertTrue($this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }
}
