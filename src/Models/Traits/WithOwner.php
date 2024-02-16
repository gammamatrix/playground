<?php
/**
 * Playground
 */
namespace Playground\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Playground\Models\Traits\WithOwner
 */
trait WithOwner
{
    /**
     * Access the owner of this model.
     */
    public function owner(): HasOne
    {
        /**
         * @var class-string $userClass
         */
        $userClass = config('auth.providers.users.model', '\\App\\Models\\User');

        return $this->hasOne($userClass, 'id', 'owned_by_id');
    }
}
