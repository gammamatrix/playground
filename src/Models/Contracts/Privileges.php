<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Playground\Models\Contracts;

/**
 * \Playground\Models\Contracts\Privileges
 *
 * @property string[] $privileges
 */
interface Privileges
{
    /**
     * Add a privilege to the model.
     *
     * @param  string  $privilege  The privilege to add to the model.
     */
    public function addPrivilege(string $privilege): self;

    /**
     * Checks to see if the user has the privilege.
     *
     * @param  string  $privilege  The privilege to check.
     */
    public function hasPrivilege(string $privilege): bool;

    /**
     * Remove a privilege from the model.
     *
     * @param  string  $privilege  The privilege to remove from the model.
     */
    public function removePrivilege(string $privilege): self;
}
