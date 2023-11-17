<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \GammaMatrix\Playground\Models\Interfaces\WithParentInterface
 *
 */
interface WithParentInterface
{
    /**
     * Get the parent of the model.
     */
    public function parent(): HasOne;
}
