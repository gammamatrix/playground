<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \GammaMatrix\Playground\Models\Traits\WithModifier
 *
 */
trait WithModifier
{
    /**
     * Access the modifier of this model.
     */
    public function modifier(): HasOne
    {
        return $this->hasOne(
            config('playground.user', '\\App\\Models\\User'),
            'id',
            'modified_by_id'
        );
    }
}
