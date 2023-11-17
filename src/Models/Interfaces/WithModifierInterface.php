<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \GammaMatrix\Playground\Models\Interfaces\WithModifierInterface
 *
 */
interface WithModifierInterface
{
    /**
     * Get the modifier of the model.
     */
    public function modifier(): HasOne;
}
