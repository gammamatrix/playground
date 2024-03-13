<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Playground\Models\Concerns\WithOwner
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
