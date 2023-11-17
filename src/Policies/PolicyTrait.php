<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Policies;

use App\Models\User;

/**
 * \GammaMatrix\Playground\Policies\PolicyTrait
 *
 */
trait PolicyTrait
{
    /**
     * @var boolean $allowRootOverride Allow root to override rules in before().
     */
    protected $allowRootOverride = true;

    /**
     * @var array $rolesForAction The roles allowed for actions in the MVC.
     */
    protected $rolesForAction = [
        'admin',
        'wheel',
        'root',
    ];

    /**
     * @var array $rolesForAdmin The roles allowed for admin actions in the MVC.
     */
    protected $rolesForAdmin = [
        'admin',
        'wheel',
        'root',
    ];

    /**
     * @var array $rolesToView The roles allowed to view the MVC.
     */
    protected $rolesToView = [
        'admin',
        'wheel',
        'root',
    ];

    /**
     * Get the roles for admin actions.
     *
     * @return array
     */
    public function getRolesForAdmin()
    {
        return $this->rolesForAdmin;
    }

    /**
     * Get the roles for standard actions.
     *
     * @return array
     */
    public function getRolesForAction()
    {
        return $this->rolesForAction;
    }

    /**
     * Get the roles for view actions.
     *
     * @return array
     */
    public function getRolesToView()
    {
        return $this->rolesToView;
    }

    /**
     * Does the user have a required privilege?
     *
     * @param  \App\Models\User  $user
     * @param  array  $privileges The required privileges.
     * @return boolean
     */
    public function hasPrivilege(User $user, array $privileges = [])
    {
        return in_array($user->privilege, $privileges)
            || array_intersect($user->privileges, $privileges)
        ;
    }

    /**
     * Does the user have a required role?
     *
     * @param  \App\Models\User  $user
     * @param  array  $roles the roles from $rolesToView, $rolesForAction, $rolesForAdmin
     * @return boolean
     */
    public function hasRole(User $user, array $roles = [])
    {
        return in_array($user->role, $roles)
            || array_intersect($user->roles, $roles)
        ;
    }
}
