<?php
/**
 * Playground
 */
namespace Playground\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Playground\Models\Concerns\WithModifier
 */
trait WithModifier
{
    /**
     * Access the modifier of this model.
     */
    public function modifier(): HasOne
    {
        /**
         * @var class-string $userClass
         */
        $userClass = config('auth.providers.users.model', '\\App\\Models\\User');

        return $this->hasOne($userClass, 'id', 'modified_by_id');
    }
}
