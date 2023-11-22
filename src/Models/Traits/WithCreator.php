<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \GammaMatrix\Playground\Models\Traits\WithCreator
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
