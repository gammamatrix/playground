<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \GammaMatrix\Playground\Models\Interfaces\WithCreatorInterface
 *
 */
interface WithCreatorInterface
{
    /**
     * Get the creator of the model.
     */
    public function creator(): HasOne;
}
