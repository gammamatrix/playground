<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \GammaMatrix\Playground\Models\Interfaces\WithOwnerInterface
 *
 */
interface WithOwnerInterface
{
    /**
     * Get the owner of the model.
     */
    public function owner(): HasOne;
}
