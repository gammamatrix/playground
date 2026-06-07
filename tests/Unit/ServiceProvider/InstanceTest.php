<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Tests\Unit\Playground\ServiceProvider;

use Playground\Models\User;
use Playground\ServiceProvider;
use Tests\Unit\Playground\TestCase;

/**
 * \Tests\Unit\Playground\ServiceProvider\InstanceTest
 */
class InstanceTest extends TestCase
{
    public function test_version(): void
    {
        /** @phpstan-ignore method.alreadyNarrowedType */
        $this->assertNotEmpty(ServiceProvider::VERSION);
        $this->assertIsString(ServiceProvider::VERSION);
    }

    public function test_user_primary_key_type_with_empty_model(): void
    {
        $instance = (new \ReflectionClass(ServiceProvider::class))->newInstanceWithoutConstructor();

        $auth_providers_users_model = null;

        $expected = '<fg=yellow;options=bold>invalid</>';

        $this->assertSame(
            $expected,
            $instance->userPrimaryKeyType($auth_providers_users_model)
        );
    }

    public function test_user_primary_key_type_with_incrementing_model(): void
    {
        $instance = (new \ReflectionClass(ServiceProvider::class))->newInstanceWithoutConstructor();

        $auth_providers_users_model = \Playground\Test\Models\User::class;

        $expected = '<fg=green;options=bold>increments</>';

        $this->assertSame(
            $expected,
            $instance->userPrimaryKeyType($auth_providers_users_model)
        );
    }

    public function test_user_primary_key_type_with_uuid_model(): void
    {
        $instance = (new \ReflectionClass(ServiceProvider::class))->newInstanceWithoutConstructor();

        $auth_providers_users_model = User::class;

        $expected = '<fg=green;options=bold>UUID</>';

        $this->assertSame(
            $expected,
            $instance->userPrimaryKeyType($auth_providers_users_model)
        );
    }

    public function test_user_primary_key_type_with_exception(): void
    {
        $instance = (new \ReflectionClass(ServiceProvider::class))->newInstanceWithoutConstructor();

        $auth_providers_users_model = \Exception::class;

        $expected = '<fg=red;options=bold>error</>';

        $this->assertSame(
            $expected,
            $instance->userPrimaryKeyType($auth_providers_users_model)
        );
    }
}
