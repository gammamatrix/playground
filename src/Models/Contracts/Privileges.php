<?php
/**
 * Playground
 */
namespace Playground\Models\Contracts;

/**
 * \Playground\Models\Contracts\Privileges
 *
 * @property array<int, string> $privileges
 */
interface Privileges
{
    /**
     * Add a privilege to the model.
     *
     * @param mixed $privilege The privilege to add to the model.
     */
    public function addPrivilege(mixed $privilege): void;

    /**
     * Checks to see if the user has the privilege.
     *
     * @param mixed $privilege The privilege to check.
     */
    public function hasPrivilege(mixed $privilege): bool;

    /**
     * Remove a privilege from the model.
     *
     * @param mixed $privilege The privilege to remove from the model.
     */
    public function removePrivilege(mixed $privilege): void;
}
