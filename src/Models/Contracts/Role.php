<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Playground\Models\Contracts;

/**
 * \Playground\Models\Contracts\Role
 *
 * @property string $role
 * @property string[] $roles
 */
interface Role
{
    /**
     * Add a role to the model.
     *
     * @param  string  $role  The role to add to the model.
     */
    public function addRole(string $role): self;

    /**
     * Checks to see if the model has the role.
     *
     * @param  string  $role  The role to check.
     */
    public function hasRole(string $role): bool;

    /**
     * Remove a role from the model.
     *
     * @param  string  $role  The role to remove from the model.
     */
    public function removeRole(string $role): self;
}
