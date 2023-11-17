<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * \GammaMatrix\Playground\Models\Interfaces\WithChildrenInterface
 *
 */
interface WithChildrenInterface
{
    /**
     * Get the children under the model.
     */
    public function children(): HasMany;
}
