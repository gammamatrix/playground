<?php
/**
 * Playground
 */
namespace Playground\Models\Concerns;

/**
 * \Playground\Models\Concerns\Privileges
 */
trait Privileges
{
    /**
     * Checks to see if the user has the privilege.
     *
     * @param mixed $privilege The privilege to check.
     */
    public function hasPrivilege(mixed $privilege): bool
    {
        if (empty($privilege) || ! is_string($privilege)) {
            return false;
        }

        $privileges = $this->getAttribute('privileges');

        return is_array($privileges) && in_array($privilege, $privileges);
    }

    /**
     * Add a privilege to the model.
     *
     * @param mixed $privilege The privilege to add to the model.
     */
    public function addPrivilege(mixed $privilege): void
    {
        $privileges = $this->getAttribute('privileges');
        if (! is_array($privileges)) {
            $privileges = [];
        }

        if (empty($privilege)
            || ! is_string($privilege)
            || in_array($privilege, $privileges)
        ) {
            return;
        }

        $privileges[] = $privilege;

        $this->setAttribute('privileges', $privileges);
    }

    /**
     * Remove a privilege from the model.
     *
     * @param mixed $privilege The privilege to remove from the model.
     */
    public function removePrivilege(mixed $privilege): void
    {
        $privileges = $this->getAttribute('privileges');
        if (! is_array($privileges)) {
            $privileges = [];
        }

        if (empty($privilege)
            || ! is_string($privilege)
            || ! in_array($privilege, $privileges)
        ) {
            return;
        }

        $privileges = array_diff($privileges, [$privilege]);

        $this->setAttribute('privileges', $privileges);
    }
}
