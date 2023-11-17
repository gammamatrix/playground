<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * \GammaMatrix\Playground\Policies\Policy
 *
 */
abstract class Policy
{
    use HandlesAuthorization;
    use PolicyTrait;

    /**
     * Perform a before check.
     *
     * NOTE Override this method when the root user should not have access.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability The ability represents an action in the MCA.
     *
     * @return mixed Returns true if the user has the root role assigned.
     */
    public function before(User $user, $ability)
    {
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
        // ]);
        if ($this->allowRootOverride && 'root' === $user->role) {
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
     * @param  \App\Models\User  $user
     *
     * @return boolean
     */
    public function index(User $user)
    {
        // \Log::debug(__METHOD__, [
        //     '$user' => $user,
        // ]);
        return $this->hasRole($user, $this->rolesToView);
    }

    /**
     * Determine whether the user can view.
     *
     * @param  \App\Models\User  $user
     *
     * @return boolean
     */
    public function view(User $user)
    {
        // \Log::debug(__METHOD__, [
        //     '$user' => $user,
        // ]);
        return $this->hasRole($user, $this->rolesToView);
    }
}
