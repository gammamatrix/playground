<?php
/**
 * Playground
 *
 */

namespace Playground\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Playground\Models\Traits\WithOwner
 *
 */
trait WithOwner
{
    /**
     * Access the owner of this model.
     */
    public function owner(): HasOne
    {
        return $this->hasOne(
            config('playground.user', '\\App\\Models\\User'),
            'id',
            'owned_by_id'
        );
    }
}
