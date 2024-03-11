<?php
/**
 * Playground
 */
namespace Playground\Models\Concerns;

/**
 * \Playground\Models\Concerns\Admin
 */
trait Admin
{
    /**
     * Checks to see if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin')
            || $this->hasRole('wheel')
            || $this->getAttribute('role') === 'root';
    }
}
