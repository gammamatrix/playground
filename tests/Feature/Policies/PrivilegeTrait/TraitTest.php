<?php
/**
 * Playground
 */
namespace Tests\Feature\Playground\Policies\PrivilegeTrait;

use Illuminate\Auth\Access\Response;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\Contracts\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Playground\Test\Models\UserWithSanctum;
use Tests\Feature\Playground\TestCase;

/**
 * \Tests\Feature\Playground\Policies\PrivilegeTrait\TraitTest
 */
class TraitTest extends TestCase
{
    public const TRAIT_CLASS = \Playground\Policies\PrivilegeTrait::class;

    public $mock;

    protected bool $load_migrations_laravel = true;

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

    public function test_hasPrivilege_and_fail_with_empty_privilege(): void
    {
        config(['playground.auth.sanctum' => true]);

        /**
         * @var UserWithSanctum&HasApiTokens $user
         */
        $user = UserWithSanctum::factory()->make();
        $privilege = '';

        $this->assertInstanceOf(Response::class, $this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    public function test_hasPrivilege_with_app_without_token_and_fail(): void
    {
        config(['playground.auth.sanctum' => true]);

        /**
         * @var UserWithSanctum&HasApiTokens $user
         */
        $user = UserWithSanctum::factory()->make();
        $privilege = 'app:*';

        $this->assertInstanceOf(Response::class, $this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    public function test_hasPrivilege_with_app_with_token_and_unauthorized_privilege_and_fail(): void
    {
        config(['playground.auth.sanctum' => true]);
        // $this->mock->expects($this->any())
        //     ->method('hasToken')
        //     ->will($this->returnValue(true))
        // ;

        /**
         * @var UserWithSanctum&HasApiTokens $user
         */
        $user = UserWithSanctum::factory()->create();
        $privilege = 'duck:goose';

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
            ->firstOrFail();

        $this->assertInstanceOf(PersonalAccessToken::class, $access_token);

        $this->mock->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($access_token));

        $this->assertInstanceOf(Response::class, $this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    public function test_hasPrivilege_with_app_with_wildcard_token_privileges_and_succeed(): void
    {
        config(['playground.auth.sanctum' => true]);
        // $this->mock->expects($this->any())
        //     ->method('hasToken')
        //     ->will($this->returnValue(true))
        // ;

        /**
         * @var UserWithSanctum&HasApiTokens $user
         */
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
            ->firstOrFail();

        $this->assertInstanceOf(PersonalAccessToken::class, $access_token);

        $this->mock->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($access_token));

        $this->assertTrue($this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    public function test_hasPrivilege_with_app_with_wildcard_secondary_token_privileges_and_succeed(): void
    {
        config(['playground.auth.sanctum' => true]);
        $this->mock->expects($this->any())
            ->method('hasToken')
            ->will($this->returnValue(true));

        /**
         * @var UserWithSanctum&HasApiTokens $user
         */
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
            ->firstOrFail();

        $this->assertInstanceOf(PersonalAccessToken::class, $access_token);

        $this->mock->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($access_token));

        $this->assertTrue($this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }

    public function test_hasPrivilege_with_app_with_token_privileges_and_succeed(): void
    {
        config(['playground.auth.sanctum' => true]);
        $this->mock->expects($this->any())
            ->method('hasToken')
            ->will($this->returnValue(true));

        /**
         * @var UserWithSanctum&HasApiTokens $user
         */
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
            ->firstOrFail();

        $this->assertInstanceOf(PersonalAccessToken::class, $access_token);

        $this->mock->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($access_token));

        $this->assertTrue($this->mock->hasPrivilege(
            $user,
            $privilege
        ));
    }
}
