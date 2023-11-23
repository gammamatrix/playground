<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Policies\PolicyTrait;

use Tests\Unit\GammaMatrix\Playground\TestCase;
use GammaMatrix\Playground\Test\Models\User;
use Illuminate\Support\Facades\Log;
use TiMacDonald\Log\LogEntry;
use TiMacDonald\Log\LogFake;

/**
 * \Tests\Unit\GammaMatrix\Playground\Policies\PolicyTrait\TraitTest
 *
 */
class TraitTest extends TestCase
{
    /**
     * @var string
     */
    public const TRAIT_CLASS = \GammaMatrix\Playground\Policies\PolicyTrait::class;

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

    public function test_getEntity()
    {
        $this->assertSame('', $this->mock->getEntity());
    }

    public function test_getPackage()
    {
        $this->assertSame('', $this->mock->getPackage());
    }

    public function test_hasToken()
    {
        $this->assertFalse($this->mock->hasToken());
    }

    public function test_getToken()
    {
        $this->assertNull($this->mock->getToken());
    }

    public function test_setToken()
    {
        $this->assertIsObject($this->mock->setToken());
    }

    public function test_verify()
    {
        LogFake::bind();

        $user = User::factory()->make();

        $verify = 'invalid-verifier';

        config(['playground.auth.verify' => $verify]);

        $ability = 'view';

        $this->assertFalse($this->mock->verify($user, $ability));

        Log::assertLogged(
            fn (LogEntry $log) => $log->level === 'debug'
        );

        Log::assertLogged(
            fn (LogEntry $log) => str_contains(
                $log->context['$ability'],
                $ability
            )
        );
    }

    public function test_verify_privileges()
    {
        $user = User::factory()->make();

        $verify = 'privileges';

        config(['playground.auth.verify' => $verify]);

        $ability = 'view';

        $this->assertFalse($this->mock->verify($user, $ability));
    }

    public function test_verify_roles()
    {
        $user = User::factory()->make();

        $verify = 'roles';

        config(['playground.auth.verify' => $verify]);

        $ability = 'view';

        $this->assertFalse($this->mock->verify($user, $ability));
    }
}
