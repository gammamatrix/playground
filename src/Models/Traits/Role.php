<?php
/**
 * Playground
 */
namespace Playground\Models\Traits;

/**
 * \Playground\Models\Traits\Role
 *
 * @property string $role
 * @property array<int, string> $roles
 */
trait Role
{
    /**
     * Checks to see if the model has the role.
     *
     * @param mixed $role The role to check.
     */
    public function hasRole(mixed $role): bool
    {
        if (empty($role) || ! is_string($role)) {
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
     * @param mixed $role The role to add to the model.
     */
    public function addRole(mixed $role): void
    {
        $roles = $this->getAttribute('roles');
        if (! is_array($roles)) {
            $roles = [];
        }

        if (empty($role)
            || ! is_string($role)
            || in_array($role, [
                'root',
            ])
            || in_array($role, $roles)
        ) {
            return;
        }

        $roles[] = $role;

        $this->setAttribute('roles', $roles);
    }

    /**
     * Remove a role from the model.
     *
     * @param mixed $role The role to remove from the model.
     */
    public function removeRole(mixed $role): void
    {
        $roles = $this->getAttribute('roles');
        if (! is_array($roles)) {
            $roles = [];
        }

        if (empty($role)
            || ! is_string($role)
            || ! in_array($role, $roles)
        ) {
            return;
        }

        $roles = array_diff($roles, [$role]);

        $this->setAttribute('roles', $roles);
    }
}
