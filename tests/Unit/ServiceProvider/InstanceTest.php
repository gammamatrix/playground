<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\ServiceProvider;

use Playground\ServiceProvider;
use Tests\Unit\Playground\TestCase;

// use TiMacDonald\Log\LogEntry;
// use TiMacDonald\Log\LogFake;

/**
 * \Tests\Unit\Playground\ServiceProvider\InstanceTest
 */
class InstanceTest extends TestCase
{
    public function test_version_matches(): void
    {
        $instance = (new \ReflectionClass(ServiceProvider::class))->newInstanceWithoutConstructor();

        $this->assertNotEmpty(ServiceProvider::VERSION);
        $this->assertIsString(ServiceProvider::VERSION);
        $this->assertSame(ServiceProvider::VERSION, $instance->version());
    }

    public function test_userPrimaryKeyType_with_empty_model(): void
    {
        $instance = (new \ReflectionClass(ServiceProvider::class))->newInstanceWithoutConstructor();

        $auth_providers_users_model = null;

        $expected = '<fg=yellow;options=bold>invalid</>';

        $this->assertSame(
            $expected,
            $instance->userPrimaryKeyType($auth_providers_users_model)
        );
    }

    public function test_userPrimaryKeyType_with_incrementing_model(): void
    {
        $instance = (new \ReflectionClass(ServiceProvider::class))->newInstanceWithoutConstructor();

        $auth_providers_users_model = \Playground\Test\Models\User::class;

        $expected = '<fg=green;options=bold>increments</>';

        $this->assertSame(
            $expected,
            $instance->userPrimaryKeyType($auth_providers_users_model)
        );
    }

    public function test_userPrimaryKeyType_with_uuid_model(): void
    {
        $instance = (new \ReflectionClass(ServiceProvider::class))->newInstanceWithoutConstructor();

        $auth_providers_users_model = \Playground\Models\User::class;

        $expected = '<fg=green;options=bold>UUID</>';

        $this->assertSame(
            $expected,
            $instance->userPrimaryKeyType($auth_providers_users_model)
        );
    }

    public function test_userPrimaryKeyType_with_exception(): void
    {
        // $log = LogFake::bind();

        $instance = (new \ReflectionClass(ServiceProvider::class))->newInstanceWithoutConstructor();

        $auth_providers_users_model = \Exception::class;

        $expected = '<fg=red;options=bold>error</>';

        $this->assertSame(
            $expected,
            $instance->userPrimaryKeyType($auth_providers_users_model)
        );

        // $log->dump();

        // $log->assertLogged(
        //     fn (LogEntry $log) => $log->level === 'debug'
        // );
        // $log->assertLogged(
        //     fn (LogEntry $log) => str_contains(
        //         $log->message,
        //         'Error: Call to undefined method Exception::getIncrementing()'
        //     )
        // );
    }
}
