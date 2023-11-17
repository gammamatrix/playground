<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \GammaMatrix\Playground\Models\Traits\WithParent
 *
 */
trait WithParent
{
    /**
     * Access the parent of this model.
     */
    public function parent(): HasOne
    {
        return $this->hasOne(
            static::class,
            'id',
            'parent_id'
        );
    }
}
