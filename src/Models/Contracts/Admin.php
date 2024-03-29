<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Models\Contracts;

/**
 * \Playground\Models\Contracts\Admin
 */
interface Admin
{
    /**
     * Checks to see if the user is an admin.
     */
    public function isAdmin(): bool;
}
