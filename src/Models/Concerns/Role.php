<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Playground\Models\Concerns;

/**
 * \Playground\Models\Concerns\Role
 *
 * @property string $role
 * @property string[] $roles
 */
trait Role
{
    /**
     * @var string[]
     */
    protected array $internalRoles = [
        'nobody',
        'root',
    ];

    /**
     * Checks to see if the model has the role.
     *
     * @param  string  $role  The role to check.
     */
    public function hasRole(string $role): bool
    {
        if (empty($role)) {
            return false;
        }

        if ($role === $this->getAttribute('role')) {
            return true;
        }

        $roles = $this->getAttribute('roles');

        return is_array($roles) && in_array($role, $roles);
    }

    /**
     * Add a role to the model.
     *
     * @param  string  $role  The role to add to the model.
     */
    public function addRole(string $role): self
    {
        if (empty($role)) {
            return $this;
        }

        $roles = $this->getAttribute('roles');
        if (! is_array($roles)) {
            $roles = [];
        }

        if (in_array($role, $this->internalRoles)
            || in_array($role, $roles)
        ) {
            return $this;
        }

        $roles[] = $role;

        $this->setAttribute('roles', $roles);

        return $this;
    }

    /**
     * Remove a role from the model.
     *
     * @param  string  $role  The role to remove from the model.
     */
    public function removeRole(string $role): self
    {
        if (empty($role)) {
            return $this;
        }

        /**
         * @var string[] $roles
         */
        $roles = $this->getAttribute('roles');
        if (! is_array($roles)) {
            $roles = [];
        }

        if (! in_array($role, $roles)) {
            return $this;
        }

        $roles = array_diff($roles, [$role]);

        $this->setAttribute('roles', $roles);

        return $this;
    }
}
