<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
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
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     */
    public function create(Authenticatable $user): bool|Response
    {
        return $this->verify($user, 'create');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * - This is for soft deletes or trash.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function delete(Authenticatable $user, Model $model): bool|Response
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
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function detail(Authenticatable $user, Model $model): bool|Response
    {
        return $this->verify($user, 'view');
    }

    /**
     * Determine whether the user can edit a model.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function edit(Authenticatable $user, Model $model = null): bool|Response
    {
        return $this->verify($user, 'edit');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * Force deletes permanently from a database.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function forceDelete(Authenticatable $user, Model $model): bool|Response
    {
        return $this->verify($user, 'forceDelete');
    }

    /**
     * Determine whether the user can lock a model.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function lock(Authenticatable $user, Model $model): bool|Response
    {
        return $this->verify($user, 'lock');
    }

    /**
     * Determine whether the user can manage the model.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function manage(Authenticatable $user, Model $model): bool|Response
    {
        return $this->verify($user, 'manage');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function restore(Authenticatable $user, Model $model): bool|Response
    {
        return $this->verify($user, 'restore');
    }

    /**
     * Determine whether the user can store the model.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     */
    public function store(Authenticatable $user): bool|Response
    {
        return $this->verify($user, 'store');
    }

    /**
     * Determine whether the user can edit a model.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function update(Authenticatable $user, Model $model): bool|Response
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
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function unlock(Authenticatable $user, Model $model): bool|Response
    {
        return $this->verify($user, 'unlock');
    }
}
