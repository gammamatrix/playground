<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;

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
        // Allow the package and slug to be defined.

        if (empty($this->package)) {
            $this->package = Str::of(__NAMESPACE__)->betweenFirst('\\', '\\')->slug()->toString();
            // $this->package = Str::of(__NAMESPACE__)->after( Str::of(__NAMESPACE__)->before('\\') )->before('\\')->slug()->toString();
        }

        if (empty($this->entity)) {
            $this->entity = Str::of(class_basename(get_called_class()))->before('Policy')->slug()->toString();
        }

        // Str::of(class_basename($model))->snake()->replace('_', ' ')->title()->lower();
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
        return $this->verify($user, 'viewAny');
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
        return $this->verify($user, 'view');
    }
}
