<?php
/**
 * Playground
 */
namespace Playground\Models\Contracts;

/**
 * \Playground\Test\Models\Traits\Admin
 */
interface Admin
{
    /**
     * Checks to see if the user is an admin.
     */
    public function isAdmin(): bool;
}
