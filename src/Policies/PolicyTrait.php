<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Str;

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

    protected string $package = '';

    protected string $entity = '';

    protected $token = null;

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

    public function privilege(string $ability = '*'): string
    {
        $privilege = '';
        if (!empty($this->package)) {
            $privilege .= $this->package;
        }

        if (!empty($this->entity)) {
            if (!empty($privilege)) {
                $privilege .= ':';
            }
            $privilege .= $this->entity;
        }

        if (!empty($ability)) {
            if (!empty($privilege)) {
                $privilege .= ':';
            }
            $privilege .= $ability;
        }

        return $privilege;
    }

    public function verify(User $user, string $ability): bool|Response
    {
        $verify = config('playground.auth.verify');
        if ('privileges' === $verify) {
            return $this->hasPrivilege($user, $this->privilege($ability));
        } elseif ('roles' === $verify) {

            return $this->hasRole($user, $this->privilege($ability));
        }
        \Log::debug(__METHOD__, [
            '$ability' => $ability,
            '$user' => $user,
        ]);
        return false;
    }

    private function hasPrivilegeWildcard(string $privilege): bool|Response
    {
        $check = '';

        foreach (explode(':', $privilege) as $part) {
            if ($check) {
                $check .= ':';
            }
            $check .= $part;
            if ($this->token->can($check.':*')) {
                return true;
            }
        }

        return false;
    }


    public function hasPrivilege(User $user, string $privilege): bool|Response
    {
        if (empty($privilege)) {
            return Response::denyWithStatus(406, __('playground::auth.unacceptable'));
        }

        if (class_implements($user, \Laravel\Sanctum\Contracts\HasApiTokens::class)) {
            if (empty($this->token)) {
                $token = $user->tokens()->where('name', config('playground-auth.token.name'))->orderBy('created_at', 'desc')->first();

                if ($token) {
                    $this->token = $token;
                    $user->withAccessToken($token);
                }
            }

            if (empty($this->token)) {
                return Response::denyWithStatus(401, __('playground::auth.unauthorized'));
            }

            if ($this->hasPrivilegeWildcard($privilege)) {
                return true;
            }

            if ($this->token->cant($privilege)) {
                return Response::denyWithStatus(401, __('playground::auth.unauthorized'));
            }
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$privilege' => $privilege,
            //     '$user->tokens()->first()' => $user->tokens()->where('name', config('playground-auth.token.name'))->first()->can($privilege),
            //     '$user->currentAccessToken()->can($privilege)' => $user->currentAccessToken()->can($privilege),
            //     '$user->currentAccessToken()->cant($privilege)' => $user->currentAccessToken()->cant($privilege),
            // ]);
            return true;
        }

        if (config('playground.auth.hasPrivilege') && method_exists($user, 'hasPrivilege')) {
            return $user->hasPrivilege($privilege);
        }

        if (config('playground.auth.userPrivileges') && array_key_exists('privileges', $user->getAttributes())) {
            $privileges = $user->getAttribute('privileges');
            if (is_array($privileges) && in_array($privilege, $privileges)) {
                return true;
            }
        }

        return Response::denyWithStatus(401, __('playground::auth.unauthorized'));
    }

    public function hasRole(User $user, string $ability): bool
    {
        if (in_array($ability, [
            'show',
            'detail',
            'index',
            'view',
            'viewAny',
        ])) {
            $roles = $this->getRolesToView();
        } elseif (in_array($ability, [
            'create',
            'edit',
            'manage',
            'store',
            'update',
        ])) {
            $roles = $this->getRolesForAction();
        } elseif (in_array($ability, [
            'delete',
            'forceDelete',
            'lock',
            'unlock',
            'restore',
        ])) {
            $roles = $this->getRolesForAdmin();
        } else {
            $roles = $this->getRolesForAdmin();
            // // Invalid role
            // return Response::denyWithStatus(406, __('playground::auth.unacceptable'));
        }

        if (config('playground.auth.hasRole') && method_exists($user, 'hasRole')) {
            // Check for any role.
            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    return true;
                }
            }
        }

        if (config('playground.auth.userRoles') && array_key_exists('roles', $user->getAttributes())) {
            $roles = $user->getAttribute('roles');

            if (is_array($roles)) {
                foreach ($roles as $role) {
                    if ($user->hasRole($role)) {
                        return true;
                    }
                }
            }
        }

        return Response::denyWithStatus(401, __('playground::auth.unauthorized'));
    }
}
