<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Str;

/**
 * \GammaMatrix\Playground\Policies\PrivilegeTrait
 *
 */
trait PrivilegeTrait
{
    abstract public function getPackage(): string;
    abstract public function getEntity(): string;
    abstract public function getToken(): ?object;
    abstract public function hasToken(): bool;
    abstract public function setToken(?object $token = null): self;

    public function privilege(string $ability = '*'): string
    {
        $privilege = '';
        if (!empty($this->getPackage())) {
            $privilege .= $this->getPackage();
        }

        if (!empty($this->getEntity())) {
            if (!empty($privilege)) {
                $privilege .= ':';
            }
            $privilege .= $this->getEntity();
        }

        if (!empty($ability)) {
            if (!empty($privilege)) {
                $privilege .= ':';
            }
            $privilege .= $ability;
        }

        return $privilege;
    }

    private function hasPrivilegeWildcard(string $privilege): bool
    {
        $check = '';
        foreach (explode(':', $privilege) as $part) {
            if ($check) {
                $check .= ':';
            }
            $check .= $part;
            if ($this->getToken()?->can($check.':*')) {
                return true;
            }
        }
        return false;
    }

    public function hasPrivilege(Authenticatable $user, string $privilege): bool|Response
    {
        if (empty($privilege)) {
            return Response::denyWithStatus(406, __('playground::auth.unacceptable'));
        }

        if (config('playground.auth.sanctum')) {
            if (!$this->hasToken()) {
                $token = $user->tokens()
                    ->where('name', config('playground.auth.token.name'))
                    // Get the latest created token.
                    ->orderBy('created_at', 'desc')
                    ->first()
                ;

                if ($token) {
                    $this->setToken($token);
                    $user->withAccessToken($token);
                } else {
                    return Response::denyWithStatus(401, __('playground::auth.unauthorized'));
                }
            }

            if ($this->hasPrivilegeWildcard($privilege)) {
                return true;
            }

            if ($this->getToken()->cant($privilege)) {
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
}
