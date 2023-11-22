<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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

    protected ?object $token = null;

    abstract public function hasPrivilege(Authenticatable $user, string $privilege): bool|Response;

    abstract public function hasRole(Authenticatable $user, string $ability): bool|Response;

    abstract public function privilege(string $ability = '*'): string;

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function getPackage(): string
    {
        return $this->package;
    }

    public function hasToken(): bool
    {
        return !empty($this->token);
    }

    public function getToken(): ?object
    {
        return $this->token;
    }

    public function setToken(?object $token = null): self
    {
        $this->token = $token;
        return $this;
    }

    public function verify(Authenticatable $user, string $ability): bool|Response
    {
        $verify = config('playground.auth.verify');
        if ('privileges' === $verify) {
            return $this->hasPrivilege($user, $this->privilege($ability));
        } elseif ('roles' === $verify) {
            return $this->hasRole($user, $ability);
        } elseif ('user' === $verify) {
            // A user with an email address passes.
            return !empty($user->getAttribute('email'));
        }
        Log::debug(__METHOD__, [
            '$ability' => $ability,
            '$user' => $user,
        ]);
        return false;
    }
}
