<?php
/**
 * Playground
 *
 */

namespace Playground\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Playground\Models\Traits\WithCreator
 *
 */
trait WithCreator
{
    /**
     * Access the creator of this model.
     */
    public function creator(): HasOne
    {
        return $this->hasOne(
            config('playground.user', '\\App\\Models\\User'),
            'id',
            'created_by_id'
        );
    }
}
