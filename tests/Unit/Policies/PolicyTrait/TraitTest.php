<?php
/**
 * Playground
 */
namespace Tests\Unit\Playground\Policies\PolicyTrait;

use Playground\Test\Models\User;
use Tests\Unit\Playground\TestCase;
use TiMacDonald\Log\LogEntry;
use TiMacDonald\Log\LogFake;

/**
 * \Tests\Unit\Playground\Policies\PolicyTrait\TraitTest
 */
class TraitTest extends TestCase
{
    /**
     * @var string
     */
    public const TRAIT_CLASS = \Playground\Policies\PolicyTrait::class;

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

    public function test_getEntity(): void
    {
        $this->assertSame('', $this->mock->getEntity());
    }

    public function test_getPackage(): void
    {
        $this->assertSame('', $this->mock->getPackage());
    }

    public function test_hasToken(): void
    {
        $this->assertFalse($this->mock->hasToken());
    }

    public function test_getToken(): void
    {
        $this->assertNull($this->mock->getToken());
    }

    public function test_setToken(): void
    {
        $this->assertIsObject($this->mock->setToken());
    }

    public function test_verify(): void
    {
        $log = LogFake::bind();

        $user = User::factory()->make();

        $verify = 'invalid-verifier';

        config(['playground.auth.verify' => $verify]);

        $ability = 'view';

        $this->assertFalse($this->mock->verify($user, $ability));

        $log->assertLogged(
            fn (LogEntry $log) => $log->level === 'debug'
        );

        $log->assertLogged(
            fn (LogEntry $log) => str_contains(
                $log->context['$ability'],
                $ability
            )
        );
    }

    public function test_verify_privileges(): void
    {
        $user = User::factory()->make();

        $verify = 'privileges';

        config(['playground.auth.verify' => $verify]);

        $ability = 'view';

        $this->assertFalse($this->mock->verify($user, $ability));
    }

    public function test_verify_roles(): void
    {
        $user = User::factory()->make();

        $verify = 'roles';

        config(['playground.auth.verify' => $verify]);

        $ability = 'view';

        $this->assertFalse($this->mock->verify($user, $ability));
    }

    public function test_verify_user(): void
    {
        $user = User::factory()->make();

        $verify = 'user';

        config(['playground.auth.verify' => $verify]);

        $ability = 'view';

        $this->assertTrue($this->mock->verify($user, $ability));
    }
}
