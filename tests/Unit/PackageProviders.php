<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground;

use Playground\ServiceProvider;

/**
 * \Tests\Unit\Playground\PackageProviders
 */
trait PackageProviders
{
    protected string $package_providers_dir = __DIR__;

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
            \Playground\Test\ServiceProvider::class,
        ];
    }
}
