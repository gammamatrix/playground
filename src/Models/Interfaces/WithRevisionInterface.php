<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * \GammaMatrix\Playground\Models\Interfaces\WithRevisionInterface
 *
 */
interface WithRevisionInterface
{
    /**
     * Get the revisions of the model.
     */
    public function revisions(): HasMany;
}
