<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Policies;

// use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
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
        }
        \Log::debug(__METHOD__, [
            '$ability' => $ability,
            '$user' => $user,
        ]);
        return false;
    }
}
