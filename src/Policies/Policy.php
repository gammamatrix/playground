<?php
/**
 * Playground
 *
 */

namespace Playground\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
// use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * \Playground\Policies\Policy
 *
 */
abstract class Policy
{
    use HandlesAuthorization;
    use PolicyTrait;
    use PrivilegeTrait;
    use RoleTrait;

    /**
     * Perform a before check.
     *
     * NOTE Override this method when the root user should not have access.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $ability The ability represents an action in the MCA.
     *
     * @return mixed Returns true if the user has the root role assigned.
     */
    public function before(Authenticatable $user, $ability)
    {
        // Allow the package and slug to be defined.

        if (empty($this->package)) {
            $this->package = Str::of(__NAMESPACE__)->betweenFirst('\\', '\\')->slug()->toString();
        }

        if (empty($this->entity)) {
            $this->entity = Str::of(class_basename(get_called_class()))->before('Policy')->slug()->toString();
        }

        // \Log::debug(__METHOD__, [
        //     '$user' => $user,
        //     '$ability' => $ability,
        //     '$this->allowRootOverride' => $this->allowRootOverride,
        // ]);
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '__FILE__' => __FILE__,
        //     '__LINE__' => __LINE__,
        //     'static::class' => static::class,
        //     '$user' => $user ? $user->toArray(): $user,
        //     '$ability' => $ability,
        //     '$this->allowRootOverride' => $this->allowRootOverride,
        //     '$this->package' => $this->package,
        //     '$this->entity' => $this->entity,
        // ]);
        if ($this->allowRootOverride && $this->isRoot($user)) {
            return true;
        }

        return null;
    }

    ////////////////////////////////////////////////////////////////////////////
    //
    // Abilities
    //
    ////////////////////////////////////////////////////////////////////////////

    /**
     * Determine whether the user can view the index.
     *
     */
    public function index(Authenticatable $user): bool|Response
    {
        // \Log::debug(__METHOD__, [
        //     '$user' => $user,
        // ]);
        return $this->verify($user, 'viewAny');
    }

    /**
     * Determine whether the user can view.
     *
     */
    public function view(Authenticatable $user): bool|Response
    {
        // \Log::debug(__METHOD__, [
        //     '$user' => $user,
        // ]);
        return $this->verify($user, 'view');
    }
}
