<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
    public function create(User $user): bool|Response
    {
        return $this->verify($user, 'create');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * - This is for soft deletes or trash.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function delete(User $user, Model $model): bool|Response
    {
        // Models must be unlocked to allow deleting.
        // NOTE: This lock check is bypassed by a root user.
        if (in_array('locked', $model->getAttributes()) && $model->locked) {
            // return Response::denyWithStatus(423);
            return Response::denyWithStatus(423, __('playground::auth.model.locked', [
                'model' => Str::of(class_basename($model))->snake()->replace('_', ' ')->title()->lower(),
            ]));
        }

        return $this->verify($user, 'delete');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function detail(User $user, Model $model): bool|Response
    {
        return $this->verify($user, 'view');
    }

    /**
     * Determine whether the user can edit a model.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function edit(User $user, Model $model = null): bool|Response
    {
        return $this->verify($user, 'edit');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * Force deletes permanently from a database.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function forceDelete(User $user, Model $model): bool|Response
    {
        return $this->verify($user, 'forceDelete');
    }

    /**
     * Determine whether the user can lock a model.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function lock(User $user, Model $model): bool|Response
    {
        return $this->verify($user, 'lock');
    }

    /**
     * Determine whether the user can manage the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function manage(User $user, Model $model): bool|Response
    {
        return $this->verify($user, 'manage');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function restore(User $user, Model $model): bool|Response
    {
        return $this->verify($user, 'restore');
    }

    /**
     * Determine whether the user can store the model.
     *
     * @param  \App\Models\User  $user
     */
    public function store(User $user): bool|Response
    {
        return $this->verify($user, 'store');
    }

    /**
     * Determine whether the user can edit a model.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function update(User $user, Model $model): bool|Response
    {
        // Models must be unlocked to allow updating.
        // NOTE: This lock check is bypassed by a root user.
        if (in_array('locked', $model->getAttributes()) && $model->locked) {
            // return Response::denyWithStatus(423);
            return Response::denyWithStatus(423, __('playground::auth.model.locked', [
                'model' => Str::of(class_basename($model))->snake()->replace('_', ' ')->title()->lower(),
            ]));
        }

        return $this->verify($user, 'update');
    }

    /**
     * Determine whether the user can unlock a model.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function unlock(User $user, Model $model): bool|Response
    {
        return $this->verify($user, 'unlock');
    }
}
