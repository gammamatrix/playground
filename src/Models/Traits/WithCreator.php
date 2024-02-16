<?php
/**
 * Playground
 */
namespace Playground\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Playground\Models\Traits\WithCreator
 */
trait WithCreator
{
    /**
     * Access the creator of this model.
     */
    public function creator(): HasOne
    {
        /**
         * @var class-string $userClass
         */
        $userClass = config('auth.providers.users.model', '\\App\\Models\\User');

        return $this->hasOne($userClass, 'id', 'created_by_id');
    }
}
