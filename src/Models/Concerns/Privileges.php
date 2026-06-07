<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Playground\Models\Concerns;

/**
 * \Playground\Models\Concerns\Privileges
 *
 * @property string[] $privileges
 */
trait Privileges
{
    /**
     * Checks to see if the user has the privilege.
     *
     * @param  string  $privilege  The privilege to check.
     */
    public function hasPrivilege(string $privilege): bool
    {
        if (empty($privilege)) {
            return false;
        }

        $privileges = $this->getAttribute('privileges');

        return is_array($privileges) && in_array($privilege, $privileges);
    }

    /**
     * Add a privilege to the model.
     *
     * @param  string  $privilege  The privilege to add to the model.
     */
    public function addPrivilege(string $privilege): self
    {
        if (empty($privilege)) {
            return $this;
        }

        $privileges = $this->getAttribute('privileges');
        if (! is_array($privileges)) {
            $privileges = [];
        }

        if (in_array($privilege, $privileges)) {
            return $this;
        }

        $privileges[] = $privilege;

        $this->setAttribute('privileges', $privileges);

        return $this;
    }

    /**
     * Remove a privilege from the model.
     *
     * @param  string  $privilege  The privilege to remove from the model.
     */
    public function removePrivilege(string $privilege): self
    {
        if (empty($privilege)) {
            return $this;
        }

        /**
         * @var string[] $privileges
         */
        $privileges = $this->getAttribute('privileges');
        if (! is_array($privileges)) {
            $privileges = [];
        }

        if (! in_array($privilege, $privileges)) {
            return $this;
        }

        $privileges = array_diff($privileges, [$privilege]);

        $this->setAttribute('privileges', $privileges);

        return $this;
    }
}
