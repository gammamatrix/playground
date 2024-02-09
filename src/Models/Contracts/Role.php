<?php
/**
 * Playground
 */
namespace Playground\Models\Contracts;

/**
 * \Playground\Models\Contracts\Role
 *
 * @property string $role
 * @property array<int, string> $roles
 */
interface Role
{
    /**
     * Add a role to the model.
     *
     * @param mixed $role The role to add to the model.
     */
    public function addRole(mixed $role): void;

    /**
     * Checks to see if the model has the role.
     *
     * @param mixed $role The role to check.
     */
    public function hasRole(mixed $role): bool;

    /**
     * Remove a role from the model.
     *
     * @param mixed $role The role to remove from the model.
     */
    public function removeRole(mixed $role): void;
}
