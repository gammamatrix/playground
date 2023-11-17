<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Policies;

use App\Models\User;
use GammaMatrix\Playground\Models\UuidModel;
use Illuminate\Auth\Access\Response;

/**
 * \GammaMatrix\Playground\Policies\ModelPolicy
 *
 */
abstract class ModelPolicy extends Policy
{
    /**
     * Determine whether the user can create model.
     *
     * @param  \App\Models\User  $user
     */
    public function create(User $user): bool
    {
        return $this->hasRole($user, $this->rolesForAction);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * - This is for soft deletes or trash.
     *
     * @param  \App\Models\User  $user
     * @param  \GammaMatrix\Playground\Models\UuidModel  $model
     */
    public function delete(User $user, UuidModel $model): bool|Response
    {
        // Models must be unlocked to allow deleting.
        // NOTE: This lock check is bypassed by a root user.
        if ($model->locked) {
            return Response::denyWithStatus(423);
        }

        return $this->hasRole($user, $this->rolesForAdmin);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \GammaMatrix\Playground\Models\UuidModel  $model
     */
    public function detail(User $user, UuidModel $model): bool
    {
        return $this->hasRole($user, $this->rolesToView);
    }

    /**
     * Determine whether the user can edit a model.
     *
     * @param  \App\Models\User  $user
     * @param  \GammaMatrix\Playground\Models\UuidModel  $model
     */
    public function edit(User $user, UuidModel $model = null): bool
    {
        return $this->hasRole($user, $this->rolesForAction);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * Force deletes permanently from a database.
     *
     * @param  \App\Models\User  $user
     * @param  \GammaMatrix\Playground\Models\UuidModel  $model
     */
    public function forceDelete(User $user, UuidModel $model): bool
    {
        return $this->hasRole($user, $this->rolesForAdmin);
    }

    /**
     * Determine whether the user can lock a model.
     *
     * @param  \App\Models\User  $user
     * @param  \GammaMatrix\Playground\Models\UuidModel  $model
     */
    public function lock(User $user, UuidModel $model): bool|Response
    {
        // This could do an owner check.
        return $this->hasRole($user, $this->rolesForAdmin);
    }

    /**
     * Determine whether the user can manage the model.
     *
     * @param  \App\Models\User  $user
     * @param  \GammaMatrix\Playground\Models\UuidModel  $model
     */
    public function manage(User $user, UuidModel $model): bool
    {
        return $this->hasRole($user, $this->rolesForAction);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \GammaMatrix\Playground\Models\UuidModel  $model
     */
    public function restore(User $user, UuidModel $model): bool
    {
        return $this->hasRole($user, $this->rolesForAction);
    }

    /**
     * Determine whether the user can store the model.
     *
     * @param  \App\Models\User  $user
     */
    public function store(User $user): bool
    {
        return $this->hasRole($user, $this->rolesForAction);
    }

    /**
     * Determine whether the user can edit a model.
     *
     * @param  \App\Models\User  $user
     * @param  \GammaMatrix\Playground\Models\UuidModel  $model
     */
    public function update(User $user, UuidModel $model): bool|Response
    {
        // Models must be unlocked to allow updating.
        // NOTE: This lock check is bypassed by a root user.
        if ($model->locked) {
            return Response::denyWithStatus(423);
        }

        return $this->hasRole($user, $this->rolesForAction);
    }

    /**
     * Determine whether the user can unlock a model.
     *
     * @param  \App\Models\User  $user
     * @param  \GammaMatrix\Playground\Models\UuidModel  $model
     */
    public function unlock(User $user, UuidModel $model): bool|Response
    {
        // This could do an owner check.
        return $this->hasRole($user, $this->rolesForAdmin);
    }
}
